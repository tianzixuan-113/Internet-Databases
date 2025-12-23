<?php
use yii\helpers\Html;
$this->title = '编辑英雄：' . $model->hero_name;
$this->params['breadcrumbs'][] = ['label' => '英雄信息管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="hero-update">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model, 'campaignOptions' => $campaignOptions]) ?>
</div>
