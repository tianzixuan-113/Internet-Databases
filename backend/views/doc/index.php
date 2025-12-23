<?php
use yii\grid\GridView; use yii\helpers\Html;
$this->title = '史料文献管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-index">
<h1><?= Html::encode($this->title) ?></h1>
<p><?= Html::a('新增文献', ['create'], ['class' => 'btn btn-success']) ?></p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'doc_id','doc_name','doc_type','related_campaign_id',
        ['class' => 'yii\\grid\\ActionColumn'],
    ],
]) ?>
</div>
