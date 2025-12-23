<?php
use yii\helpers\Html; use yii\widgets\ActiveForm;
/* @var $model common\models\HistoricalDoc */
?>
<div class="doc-form">
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'doc_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'doc_type')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'related_campaign_id')->textInput() ?>
<?= $form->field($model, 'doc_summary')->textarea(['rows' => 6]) ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
