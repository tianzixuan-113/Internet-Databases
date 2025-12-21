<?php
use yii\helpers\Html;
$this->title = '新增文献';
$this->params['breadcrumbs'][] = ['label' => '史料文献管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-create">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
