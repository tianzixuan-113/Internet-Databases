<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ImageResource */

$this->title = $model->title ?: ('图片 #' . $model->img_id);
$this->params['breadcrumbs'][] = ['label' => '图片资源管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="image-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->img_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->img_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该图片记录吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'img_id',
            'title',
            'file_path',
            'related_id',
            'description:ntext',
        ],
    ]) ?>
</div>
