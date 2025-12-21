<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\DataStatistics */
$this->title = '新增统计';
$this->params['breadcrumbs'][] = ['label' => '数据统计管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistics-create">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
