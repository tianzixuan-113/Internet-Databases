<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\models\User;
use common\models\WarCampaign;
use common\models\HeroInfo;
use common\models\HistoricalDoc;
use common\models\ImageResource;
use common\models\RelicInfo;
use common\models\MessageBoard;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [ 'allow' => true, 'roles' => ['@'] ],
                ],
            ],
            'verbs' => [ 'class' => VerbFilter::className(), 'actions' => [] ],
        ];
    }

    public function asJson($data)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    public function actionTotals()
    {
        $cache = Yii::$app->cache;
        $totals = $cache->getOrSet('api_totals', function() {
            return [
                'users' => (int)User::find()->count(),
                'campaigns' => (int)WarCampaign::find()->count(),
                'heroes' => (int)HeroInfo::find()->count(),
                'docs' => (int)HistoricalDoc::find()->count(),
                'images' => (int)ImageResource::find()->count(),
                'relics' => (int)RelicInfo::find()->count(),
                'messages' => (int)MessageBoard::find()->count(),
            ];
        }, 300);
        return $this->asJson(['ok' => true, 'data' => $totals]);
    }

    // 战役年份统计
    public function actionCampaignYears()
    {
        $rows = (new \yii\db\Query())
            ->select([ 'year' => 'YEAR(start_time)', 'count' => 'COUNT(*)' ])
            ->from(WarCampaign::tableName())
            ->groupBy(['YEAR(start_time)'])
            ->orderBy(['YEAR(start_time)' => SORT_ASC])
            ->all();
        return $this->asJson(['ok' => true, 'data' => $rows]);
    }

    // 英雄数按战役 Top N
    public function actionHeroTopCampaigns($limit = 10)
    {
        $limit = max(1, min((int)$limit, 50));
        $rows = (new \yii\db\Query())
            ->select(['campaign_id', 'count' => 'COUNT(*)'])
            ->from(HeroInfo::tableName())
            ->groupBy(['campaign_id'])
            ->orderBy(['count' => SORT_DESC])
            ->limit($limit)
            ->all();
        return $this->asJson(['ok' => true, 'data' => $rows]);
    }

    // 最近资源列表（按类型）
    public function actionRecent($type = 'messages', $limit = 10)
    {
        $limit = max(1, min((int)$limit, 50));
        $type = strtolower(trim((string)$type));
        switch ($type) {
            case 'messages':
                $query = MessageBoard::find()->orderBy(['msg_time' => SORT_DESC]);
                break;
            case 'publish':
                $query = (new \yii\db\Query())
                    ->from('{{%publish_info}}')
                    ->orderBy(['publish_time' => SORT_DESC]);
                $rows = $query->limit($limit)->all();
                return $this->asJson(['ok' => true, 'data' => $rows]);
            case 'campaigns':
                $query = WarCampaign::find()->orderBy(['start_time' => SORT_DESC]);
                break;
            case 'docs':
                $query = HistoricalDoc::find()->orderBy(['doc_id' => SORT_DESC]);
                break;
            case 'images':
                $query = ImageResource::find()->orderBy(['img_id' => SORT_DESC]);
                break;
            case 'relics':
                $query = RelicInfo::find()->orderBy(['relic_id' => SORT_DESC]);
                break;
            default:
                return $this->asJson(['ok' => false, 'error' => 'unsupported type']);
        }
        $rows = $query->limit($limit)->asArray()->all();
        return $this->asJson(['ok' => true, 'data' => $rows]);
    }

    public function actionVisitsSummary($days = 7)
    {
        $days = max(1, min((int)$days, 30));
        $start = time() - ($days * 86400);
        $cache = Yii::$app->cache;
        $rows = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $day = date('Y-m-d', time() - $i * 86400);
            $rows[] = [ 'day' => $day, 'count' => (int)$cache->get('fvisit:day:' . $day) ];
        }
        return $this->asJson(['ok' => true, 'data' => $rows]);
    }

    public function actionTopRoutes($limit = 10)
    {
        $limit = max(1, min((int)$limit, 50));
        $routes = Yii::$app->cache->get('fvisit:routes');
        if (!is_array($routes)) { $routes = []; }
        arsort($routes);
        $data = [];
        foreach (array_slice($routes, 0, $limit, true) as $route => $count) {
            $data[] = ['route' => $route, 'count' => (int)$count];
        }
        return $this->asJson(['ok' => true, 'data' => $data]);
    }

    // 图片域名分布 Top N（其余合并为“其他”）
    public function actionImageHostDist($top = 8)
    {
        $top = max(1, min((int)$top, 20));
        $rows = (new \yii\db\Query())
            ->select(['img_url'])
            ->from(ImageResource::tableName())
            ->all();
        $hostMap = [];
        foreach ($rows as $r) {
            $raw = trim((string)$r['img_url']);
            if ($raw === '') continue;
            if (!preg_match('/^https?:\/\//i', $raw)) { $raw = 'http://' . ltrim($raw, '/'); }
            $host = parse_url($raw, PHP_URL_HOST) ?: 'unknown';
            $hostMap[$host] = ($hostMap[$host] ?? 0) + 1;
        }
        arsort($hostMap);
        $data = []; $other = 0; $i = 0;
        foreach ($hostMap as $host => $cnt) {
            if ($i < $top) { $data[] = ['host' => $host, 'count' => (int)$cnt]; }
            else { $other += (int)$cnt; }
            $i++;
        }
        if ($other > 0) { $data[] = ['host' => '其他', 'count' => $other]; }
        return $this->asJson(['ok' => true, 'data' => $data]);
    }

    public function actionProbeImage($url)
    {
        $url = trim((string)$url);
        if ($url === '') { return $this->asJson(['ok' => false, 'error' => 'empty url']); }
        $cacheKey = 'probe_image_' . md5($url);
        $data = Yii::$app->cache->getOrSet($cacheKey, function() use ($url) {
            $client = new Client([ 'timeout' => 6.0 ]);
            try {
                $res = $client->request('GET', $url, [ 'headers' => ['User-Agent' => 'StatsProbe/1.0'], 'http_errors' => false ]);
                $status = $res->getStatusCode();
                $contentType = $res->getHeaderLine('Content-Type');
                $bytes = $res->getBody()->getContents();
                $width = null; $height = null;
                if (stripos($contentType, 'image/') !== false && $bytes) {
                    $info = @getimagesizefromstring($bytes);
                    if ($info) { $width = $info[0] ?? null; $height = $info[1] ?? null; }
                }
                return [
                    'status' => $status,
                    'contentType' => $contentType,
                    'width' => $width,
                    'height' => $height,
                    'size' => strlen($bytes),
                ];
            } catch (\Throwable $e) {
                return [ 'status' => 0, 'error' => $e->getMessage() ];
            }
        }, 120);
        return $this->asJson(['ok' => true, 'data' => $data]);
    }

    // 批量图片链接检测：urls=逗号分隔 或 POST JSON 数组
    public function actionImagesCheck($limit = 20)
    {
        $limit = max(1, min((int)$limit, 50));
        $urlsParam = Yii::$app->request->get('urls');
        $list = [];
        if ($urlsParam) {
            $list = array_filter(array_map('trim', explode(',', $urlsParam)));
        } else {
            $raw = Yii::$app->request->getRawBody();
            $json = json_decode($raw, true);
            if (is_array($json)) { $list = $json; }
        }
        $list = array_slice($list, 0, $limit);
        $out = [];
        foreach ($list as $url) {
            $url = (string)$url;
            $cacheKey = 'probe_image_' . md5($url);
            $data = Yii::$app->cache->get($cacheKey);
            if ($data === false) {
                // 调用单链接探测以填充缓存
                $data = $this->actionProbeImage($url);
                // actionProbeImage 返回的是数组而非纯 data，这里做兼容
                if (is_array($data) && isset($data['data'])) { $data = $data['data']; }
            }
            $out[] = ['url' => $url, 'info' => $data];
        }
        return $this->asJson(['ok' => true, 'data' => $out]);
    }
}
