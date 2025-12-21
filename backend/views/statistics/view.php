<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DataStatistics */

$this->title = $model->stat_year . ' 年统计';
$this->params['breadcrumbs'][] = ['label' => '统计数据管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="statistics-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该统计记录吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'stat_year',
            'battle_count',
            'hero_count',
            'relic_count',
            'doc_count',
        ],
    ]) ?>
</div>
