<?php
use yii\grid\GridView; use yii\helpers\Html;
$this->title = '文物信息管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relic-index">
<h1><?= Html::encode($this->title) ?></h1>
<p><?= Html::a('新增文物', ['create'], ['class' => 'btn btn-success']) ?></p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'relic_id','relic_name','relic_type','age','collection_place',
        ['class' => 'yii\\grid\\ActionColumn'],
    ],
]) ?>
</div>
