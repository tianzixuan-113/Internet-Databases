<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WarCampaign */

$this->title = $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => '战役管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="campaign-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->campaign_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->campaign_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除这条战役记录吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'campaign_id',
            'campaign_name',
            'start_time',
            'end_time',
            'location',
            'warring_parties',
            'result',
            'description:ntext',
        ],
    ]) ?>
</div>
