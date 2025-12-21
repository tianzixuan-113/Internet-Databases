<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PublishInfo */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '资讯发布管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="publish-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->publish_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->publish_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该资讯吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'publish_id',
            'title',
            'content:ntext',
            'publish_time',
            'publisher_id',
        ],
    ]) ?>
</div>
