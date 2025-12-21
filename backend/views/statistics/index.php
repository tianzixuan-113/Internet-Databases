<?php
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '数据统计管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistics-index">
<h1><?= Html::encode($this->title) ?></h1>
<p><?= Html::a('新增统计', ['create'], ['class' => 'btn btn-success']) ?></p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'stat_id',
        'stat_type',
        'stat_year',
        'stat_count',
        ['class' => 'yii\\grid\\ActionColumn'],
    ],
]) ?>
</div>
