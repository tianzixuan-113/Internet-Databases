<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MemberInfo */

?>

<div class="member-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'member_id')->textInput() ?>
    <?= $form->field($model, 'member_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'student_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'duty')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'introduction')->textarea(['rows' => 3]) ?>
    <?= $form->field($model, 'team_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '保存', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
