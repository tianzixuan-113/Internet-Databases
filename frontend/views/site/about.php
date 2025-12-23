<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '关于页面 · 团队文档与作业下载';
$this->params['breadcrumbs'][] = $this->title;

$downloadsWeb = Yii::getAlias('@web') . '/downloads';
$downloadsRoot = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'downloads';

$files = [];
if (is_dir($downloadsRoot)) {
    foreach (scandir($downloadsRoot) as $f) {
        if ($f === '.' || $f === '..') continue;
        $path = $downloadsRoot . DIRECTORY_SEPARATOR . $f;
        if (is_file($path)) {
            $files[] = [
                'name' => $f,
                'url' => $downloadsWeb . '/' . rawurlencode($f),
                'size' => filesize($path)
            ];
        }
    }
}
?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="section-sub">将团队文档（计划书、报告、PPT）与个人作业（实验、心得、总结）统一放在目录：/frontend/web/downloads/ 即可自动展示下载链接。</p>

    <div class="chart-panel">
        <h3 style="margin-top:0;">下载列表</h3>
        <?php if (empty($files)): ?>
            <p>尚未发现可下载文件。请将文件上传至项目目录：frontend/web/downloads/ 后刷新本页。</p>
        <?php else: ?>
            <ul class="list-unstyled">
                <?php foreach ($files as $file): ?>
                    <li style="margin-bottom:8px;">
                        <i class="fa-solid fa-file-lines" style="color:#4ea1ff;"></i>
                        <?= Html::a(Html::encode($file['name']), $file['url'], ['target' => '_blank']) ?>
                        <span class="text-muted">（<?= number_format($file['size']/1024, 1) ?> KB）</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="chart-panel" style="margin-top:16px;">
        <h3 style="margin-top:0;">维护说明</h3>
        <ul>
            <li>将文件放入目录：frontend/web/downloads/（可建子目录按类别区分）。</li>
            <li>文件命名建议：团队-文档类型-日期，例如：TeamA-项目计划书-2025-12.pdf。</li>
            <li>如需隐藏文件，请临时移出该目录或改名为以「_」开头。</li>
        </ul>
    </div>
</div>
