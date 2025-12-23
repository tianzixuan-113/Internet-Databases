<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\DataStatistics */
?>
<div class="statistics-form">
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'stat_type')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'stat_year')->textInput() ?>
<?= $form->field($model, 'stat_count')->textInput() ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
