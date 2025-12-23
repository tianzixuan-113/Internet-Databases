<?php
use yii\grid\GridView; use yii\helpers\Html;
$this->title = '图片资源管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">
<h1><?= Html::encode($this->title) ?></h1>
<p><?= Html::a('新增图片', ['create'], ['class' => 'btn btn-success']) ?></p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'img_id','img_url','img_desc','related_id',
        ['class' => 'yii\\grid\\ActionColumn'],
    ],
]) ?>
</div>
