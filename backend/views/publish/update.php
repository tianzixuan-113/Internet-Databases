<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PublishInfo */

$this->title = '编辑资讯：' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '资讯发布管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>

<div class="publish-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
