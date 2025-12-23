<?php
use yii\helpers\Html; use yii\widgets\ActiveForm;
/* @var $model common\models\ImageResource */
?>
<div class="image-form">
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'img_desc')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'related_id')->textInput() ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
