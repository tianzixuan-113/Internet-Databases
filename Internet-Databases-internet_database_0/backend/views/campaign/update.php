<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WarCampaign */

$this->title = '编辑战役：' . $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => '战役管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>

<div class="campaign-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
