<?php
use yii\helpers\Html;
$this->title = '新增文物';
$this->params['breadcrumbs'][] = ['label' => '文物信息管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relic-create">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
