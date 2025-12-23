<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\WarCampaign;
use common\models\HeroInfo;
use common\models\HistoricalDoc;
use common\models\ImageResource;
use common\models\RelicInfo;

class StatsController extends Controller
{
    public function actionIndex()
    {
        // Totals
        $totals = [
            'campaigns' => (int)WarCampaign::find()->count(),
            'heroes'    => (int)HeroInfo::find()->count(),
            'docs'      => (int)HistoricalDoc::find()->count(),
            'images'    => (int)ImageResource::find()->count(),
            'relics'    => (int)RelicInfo::find()->count(),
        ];

        // Campaigns per year (ascending years)
        $campaignByYear = (new \yii\db\Query())
            ->select(['year' => 'YEAR(start_time)', 'count' => 'COUNT(*)'])
            ->from(WarCampaign::tableName())
            ->groupBy(['YEAR(start_time)'])
            ->orderBy(['YEAR(start_time)' => SORT_ASC])
            ->all();

        // Frontend visit trend (last 7 days) based on shared cache keys fvisit:day:YYYY-mm-dd
        $visitTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = date('Y-m-d', time() - $i * 86400);
            $visitTrend[] = ['day' => $day, 'count' => (int)Yii::$app->cache->get('fvisit:day:' . $day)];
        }

        // Top routes from shared cache (frontend visits)
        $routes = Yii::$app->cache->get('fvisit:routes');
        if (!is_array($routes)) { $routes = []; }
        arsort($routes);
        $topRoutes = [];
        $i = 0;
        foreach ($routes as $route => $count) {
            $topRoutes[] = ['route' => (string)$route, 'count' => (int)$count];
            if (++$i >= 8) break;
        }

        // Image host distribution (group by URL host)
        $all = (new \yii\db\Query())
            ->select(['img_url'])
            ->from(\common\models\ImageResource::tableName())
            ->all();
        $hostMap = [];
        foreach ($all as $row) {
            $raw = trim((string)$row['img_url']);
            if ($raw === '') continue;
            if (!preg_match('/^https?:\/\//i', $raw)) { $raw = 'http://' . ltrim($raw, '/'); }
            $host = parse_url($raw, PHP_URL_HOST) ?: 'unknown';
            $hostMap[$host] = ($hostMap[$host] ?? 0) + 1;
        }
        arsort($hostMap);
        $imageHostDist = [];
        $other = 0; $idx = 0;
        foreach ($hostMap as $host => $cnt) {
            if ($idx < 8) { $imageHostDist[] = ['host' => $host, 'count' => (int)$cnt]; }
            else { $other += (int)$cnt; }
            $idx++;
        }
        if ($other > 0) { $imageHostDist[] = ['host' => '其他', 'count' => $other]; }

        return $this->render('index', [
            'totals' => $totals,
            'campaignByYear' => $campaignByYear,
            'visitTrend' => $visitTrend,
            'topRoutes' => $topRoutes,
            'imageHostDist' => $imageHostDist,
        ]);
    }

    public function actionData($days = 7)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $days = max(1, min((int)$days, 30));

        $totals = [
            'campaigns' => (int)WarCampaign::find()->count(),
            'heroes'    => (int)HeroInfo::find()->count(),
            'docs'      => (int)HistoricalDoc::find()->count(),
            'images'    => (int)ImageResource::find()->count(),
            'relics'    => (int)RelicInfo::find()->count(),
        ];

        $campaignByYear = (new \yii\db\Query())
            ->select(['year' => 'YEAR(start_time)', 'count' => 'COUNT(*)'])
            ->from(WarCampaign::tableName())
            ->groupBy(['YEAR(start_time)'])
            ->orderBy(['YEAR(start_time)' => SORT_ASC])
            ->all();

        $visitTrend = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $day = date('Y-m-d', time() - $i * 86400);
            $visitTrend[] = ['day' => $day, 'count' => (int)\Yii::$app->cache->get('fvisit:day:' . $day)];
        }

        // dynamic top routes (from cache)
        $routes = \Yii::$app->cache->get('fvisit:routes');
        if (!is_array($routes)) { $routes = []; }
        arsort($routes);
        $topRoutes = [];
        $i = 0;
        foreach ($routes as $route => $count) {
            $topRoutes[] = ['route' => (string)$route, 'count' => (int)$count];
            if (++$i >= 8) break;
        }

        // dynamic image host distribution
        $all = (new \yii\db\Query())
            ->select(['img_url'])
                ->from(\common\models\ImageResource::tableName())
            ->all();
        $hostMap = [];
        foreach ($all as $row) {
            $raw = trim((string)$row['img_url']);
            if ($raw === '') continue;
            if (!preg_match('/^https?:\/\//i', $raw)) { $raw = 'http://' . ltrim($raw, '/'); }
            $host = parse_url($raw, PHP_URL_HOST) ?: 'unknown';
            $hostMap[$host] = ($hostMap[$host] ?? 0) + 1;
        }
        arsort($hostMap);
        $imageHostDist = [];
        $other = 0; $idx = 0;
        foreach ($hostMap as $host => $cnt) {
            if ($idx < 8) { $imageHostDist[] = ['host' => $host, 'count' => (int)$cnt]; }
            else { $other += (int)$cnt; }
            $idx++;
        }
        if ($other > 0) { $imageHostDist[] = ['host' => '其他', 'count' => $other]; }

        return [
            'ok' => true,
            'data' => [
                'totals' => $totals,
                'campaignByYear' => $campaignByYear,
                'visitTrend' => $visitTrend,
                'topRoutes' => $topRoutes,
                'imageHostDist' => $imageHostDist,
            ]
        ];
    }
}
