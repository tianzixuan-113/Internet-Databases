<?php
use yii\grid\GridView; use yii\helpers\Html;
$this->title = '权限管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">
<h1><?= Html::encode($this->title) ?></h1>
<p><?= Html::a('新增权限', ['create'], ['class' => 'btn btn-success']) ?></p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'perm_id','member_id','perm_level','perm_desc',
        ['class' => 'yii\\grid\\ActionColumn'],
    ],
]) ?>
</div>
