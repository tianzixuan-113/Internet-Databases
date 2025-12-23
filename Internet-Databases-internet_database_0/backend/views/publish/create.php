<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PublishInfo */

$this->title = '发布新资讯';
$this->params['breadcrumbs'][] = ['label' => '资讯发布管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="publish-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
