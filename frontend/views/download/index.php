<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $teamFiles array */
/* @var $personalFiles array */

$this->title = '作业下载';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="download-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-default">
        <div class="panel-heading">团队作业（/data/team）</div>
        <div class="panel-body">
            <?php if (!empty($teamFiles)): ?>
                <ul class="list-group">
                    <?php foreach ($teamFiles as $f): ?>
                        <li class="list-group-item">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                            <?= Html::a(Html::encode($f['name']), $f['url'], ['target' => '_blank']) ?>
                            <span class="text-muted" style="margin-left:10px;">(<?= number_format($f['size']) ?> bytes)</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>暂无团队作业文件。请将文件放入 /data/team 目录。</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">个人作业（/data/personal）</div>
        <div class="panel-body">
            <?php if (!empty($personalFiles)): ?>
                <ul class="list-group">
                    <?php foreach ($personalFiles as $f): ?>
                        <li class="list-group-item">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                            <?= Html::a(Html::encode($f['name']), $f['url'], ['target' => '_blank']) ?>
                            <span class="text-muted" style="margin-left:10px;">(<?= number_format($f['size']) ?> bytes)</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>暂无个人作业文件。请将文件放入 /data/personal 目录。</p>
            <?php endif; ?>
        </div>
    </div>
</div>
