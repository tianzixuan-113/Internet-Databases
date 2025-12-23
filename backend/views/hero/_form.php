<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $model common\models\HeroInfo */
?>
<div class="hero-form">
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'hero_id')->textInput() ?>
<?= $form->field($model, 'hero_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'native_place')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'army')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'campaign_id')->dropDownList($campaignOptions, ['prompt' => '请选择战役']) ?>
<?= $form->field($model, 'deed')->textarea(['rows' => 5]) ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
