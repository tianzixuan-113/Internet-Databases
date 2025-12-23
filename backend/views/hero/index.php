<?php
use yii\grid\GridView; use yii\helpers\Html;
$this->title = '英雄信息管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hero-index">
<h1><?= Html::encode($this->title) ?></h1>
<p>
    <?= Html::a('新增英雄', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('切换为看板', ['board'], ['class' => 'btn btn-default']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'hero_id','hero_name','native_place','army','campaign_id',
        ['class' => 'yii\\grid\\ActionColumn'],
    ],
]) ?>
</div>
