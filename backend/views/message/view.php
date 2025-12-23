<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MessageBoard */

$this->title = '留言 #' . $model->msg_id;
$this->params['breadcrumbs'][] = ['label' => '留言管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="message-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('删除', ['delete', 'id' => $model->msg_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该留言吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'msg_id',
            'nickname',
            'content:ntext',
            'msg_time',
            'contact',
        ],
    ]) ?>
</div>
