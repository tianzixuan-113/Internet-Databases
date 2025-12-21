<?php
use yii\helpers\Html;
$this->title = '新增英雄';
$this->params['breadcrumbs'][] = ['label' => '英雄信息管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hero-create">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
