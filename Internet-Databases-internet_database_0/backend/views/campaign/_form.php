<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WarCampaign */

?>

<div class="campaign-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'campaign_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'start_time')->textInput() ?>
    <?= $form->field($model, 'end_time')->textInput() ?>
    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'warring_parties')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'result')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
