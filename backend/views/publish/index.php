<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '资讯发布管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="publish-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('发布新资讯', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'publish_id',
            'title',
            'publish_time',
            'publisher_id',
            [
                'class' => 'yii\\grid\\ActionColumn',
            ],
        ],
    ]) ?>
</div>
