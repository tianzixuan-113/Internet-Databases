<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WarCampaign */

$this->title = '新增战役';
$this->params['breadcrumbs'][] = ['label' => '战役管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="campaign-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
