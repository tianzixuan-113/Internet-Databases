<?php
use yii\helpers\Html;
$this->title = '编辑图片：' . $model->img_id;
$this->params['breadcrumbs'][] = ['label' => '图片资源管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="image-update">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
