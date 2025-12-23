<?php
use yii\helpers\Html;
$this->title = '编辑文献：' . $model->doc_name;
$this->params['breadcrumbs'][] = ['label' => '史料文献管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="doc-update">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
