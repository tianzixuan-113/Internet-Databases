<?php
use yii\helpers\Html;
$this->title = '编辑权限：' . $model->perm_id;
$this->params['breadcrumbs'][] = ['label' => '权限管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="permission-update">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
