<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\DataStatistics */
$this->title = '编辑统计：' . $model->stat_type . ' / ' . $model->stat_year;
$this->params['breadcrumbs'][] = ['label' => '数据统计管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="statistics-update">
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
