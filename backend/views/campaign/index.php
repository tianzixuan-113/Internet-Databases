<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '战役管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="campaign-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增战役', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('切换为时间轴', ['timeline'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'campaign_id',
            'campaign_name',
            'start_time',
            'end_time',
            'location',
            [
                'class' => 'yii\\grid\\ActionColumn',
            ],
        ],
    ]) ?>
</div>
