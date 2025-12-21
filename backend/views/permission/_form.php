<?php
use yii\helpers\Html; use yii\widgets\ActiveForm;
/* @var $model common\models\Permission */
?>
<div class="permission-form">
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'member_id')->textInput() ?>
<?= $form->field($model, 'perm_level')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'perm_desc')->textInput(['maxlength' => true]) ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
