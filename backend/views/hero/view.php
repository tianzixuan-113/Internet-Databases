<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\HeroInfo */

$this->title = $model->hero_name;
$this->params['breadcrumbs'][] = ['label' => '英雄管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="hero-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->hero_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->hero_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该英雄记录吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'hero_id',
            'hero_name',
            'native_place',
            'army',
            'campaign_id',
            'deed:ntext',
        ],
    ]) ?>
</div>
