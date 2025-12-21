<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RelicInfo */

$this->title = $model->relic_name;
$this->params['breadcrumbs'][] = ['label' => '文物管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="relic-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->relic_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->relic_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该文物记录吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'relic_id',
            'relic_name',
            'location',
            'era',
            'description:ntext',
        ],
    ]) ?>
</div>
