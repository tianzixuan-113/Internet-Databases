<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Permission */

$this->title = '权限 #' . $model->perm_id;
$this->params['breadcrumbs'][] = ['label' => '权限管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="permission-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->perm_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->perm_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该权限记录吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'perm_id',
            'member_id',
            'perm_level',
            'perm_desc',
        ],
    ]) ?>
</div>
