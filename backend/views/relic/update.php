<?php
use yii\helpers\Html;
$this->title = '编辑文物：' . $model->relic_name;
$this->params['breadcrumbs'][] = ['label' => '文物信息管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="relic-update">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
