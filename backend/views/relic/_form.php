<?php
use yii\helpers\Html; use yii\widgets\ActiveForm;
/* @var $model common\models\RelicInfo */
?>
<div class="relic-form">
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'relic_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'relic_type')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'collection_place')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
