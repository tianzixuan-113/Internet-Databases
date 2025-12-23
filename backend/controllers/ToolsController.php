<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use GuzzleHttp\Client;

class ToolsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [ 'allow' => true, 'roles' => ['admin'] ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $result = [
            'cleared' => false,
            'logTail' => '',
            'probes' => [],
        ];

        if (Yii::$app->request->isPost) {
            $action = Yii::$app->request->post('action');
            if ($action === 'clearCache') {
                Yii::$app->cache->flush();
                $this->clearAssetCache();
                Yii::$app->session->setFlash('success', '缓存与资产已清理');
                $result['cleared'] = true;
            } elseif ($action === 'tailLog') {
                $result['logTail'] = $this->tailLog(200);
            } elseif ($action === 'probe') {
                $urls = (string)Yii::$app->request->post('urls', '');
                $result['probes'] = $this->probeUrls($urls);
            }
        }

        return $this->render('index', $result);
    }

    private function clearAssetCache(): void
    {
        $paths = [
            Yii::getAlias('@backend/runtime/cache'),
            Yii::getAlias('@common/runtime/cache'),
            Yii::getAlias('@backend/web/assets'),
        ];
        foreach ($paths as $p) {
            if (is_dir($p)) {
                FileHelper::removeDirectory($p);
                FileHelper::createDirectory($p);
            }
        }
    }

    private function tailLog(int $lines = 200): string
    {
        $logPath = Yii::getAlias('@backend/runtime/logs/app.log');
        if (!is_file($logPath)) return '日志文件不存在：' . $logPath;
        $content = @file($logPath, FILE_IGNORE_NEW_LINES) ?: [];
        $tail = array_slice($content, -1 * max(1, $lines));
        return implode("\n", $tail);
    }

    private function probeUrls(string $raw): array
    {
        $lines = preg_split('/\r?\n/', trim($raw));
        $urls = [];
        foreach ($lines as $l) {
            $l = trim($l);
            if ($l === '') continue;
            if (!preg_match('~^https?://~i', $l)) $l = 'http://' . $l;
            $urls[] = $l;
            if (count($urls) >= 20) break; // limit
        }
        if (!$urls) return [];
        $client = new Client(['timeout' => 6.0, 'http_errors' => false, 'verify' => false]);
        $results = [];
        foreach ($urls as $u) {
            $status = null; $type = ''; $bytes = 0; $ok = false; $err = '';
            try {
                $res = $client->request('GET', $u, [
                    'headers' => ['Referer' => '', 'User-Agent' => 'YiiProbe/1.0'],
                ]);
                $status = $res->getStatusCode();
                $type = $res->getHeaderLine('Content-Type');
                $body = (string)$res->getBody();
                $bytes = strlen($body);
                $ok = ($status >= 200 && $status < 400);
            } catch (\Throwable $e) {
                $err = $e->getMessage();
            }
            $results[] = [
                'url' => $u,
                'status' => $status,
                'contentType' => $type,
                'bytes' => $bytes,
                'ok' => $ok,
                'error' => $err,
            ];
        }
        return $results;
    }
}
