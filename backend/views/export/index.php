<?php
use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = '数据导出';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="export-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>选择需要导出的数据类型，下载 CSV 文件（最多 10000 条）。</p>

    <div class="list-group" style="max-width:360px;">
        <a class="list-group-item" href="<?= Html::encode(\yii\helpers\Url::to(['download', 'type' => 'images'])) ?>">导出图片资源</a>
        <a class="list-group-item" href="<?= Html::encode(\yii\helpers\Url::to(['download', 'type' => 'heroes'])) ?>">导出英雄信息</a>
        <a class="list-group-item" href="<?= Html::encode(\yii\helpers\Url::to(['download', 'type' => 'messages'])) ?>">导出留言（如存在）</a>
    </div>
</div>
