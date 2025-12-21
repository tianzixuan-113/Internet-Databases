<?php
use yii\helpers\Html;
$this->title = '新增图片';
$this->params['breadcrumbs'][] = ['label' => '图片资源管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-create">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
