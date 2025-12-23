<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class DownloadController extends Controller
{
    public function actionIndex()
    {
        $webroot = Yii::getAlias('@webroot');
        $teamDir = $webroot . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'team';
        $personalDir = $webroot . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'personal';

        $teamFiles = $this->listFiles($teamDir, '/data/team');
        $personalFiles = $this->listFiles($personalDir, '/data/personal');
        // 排序：按文件名自然排序，确保团队作业1-7依次显示
        usort($teamFiles, function($a, $b) { return strnatcasecmp($a['name'], $b['name']); });
        usort($personalFiles, function($a, $b) { return strnatcasecmp($a['name'], $b['name']); });

        return $this->render('index', [
            'teamFiles' => $teamFiles,
            'personalFiles' => $personalFiles,
        ]);
    }

    private function listFiles($dir, $webPrefix)
    {
        $out = [];
        if (!is_dir($dir)) { return $out; }
        $items = scandir($dir);
        foreach ($items as $name) {
            if ($name === '.' || $name === '..') { continue; }
            $path = $dir . DIRECTORY_SEPARATOR . $name;
            if (is_file($path)) {
                $out[] = [
                    'name' => $name,
                    'size' => filesize($path),
                    'url' => $webPrefix . '/' . rawurlencode($name),
                ];
            }
        }
        return $out;
    }
}
