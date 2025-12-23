<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TeamInfo */

$this->title = '编辑团队信息: ' . $model->team_name;
$this->params['breadcrumbs'][] = ['label' => '团队信息管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>

<div class="team-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'team_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'project_topic')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'division_work')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
