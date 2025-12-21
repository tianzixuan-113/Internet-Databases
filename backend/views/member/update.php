<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MemberInfo */

$this->title = '编辑成员：' . $model->member_name;
$this->params['breadcrumbs'][] = ['label' => '成员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑';
?>

<div class="member-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
