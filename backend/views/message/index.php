<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '留言管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="message-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'msg_id',
            'nickname',
            'content:ntext',
            'msg_time',
            [
                'class' => 'yii\\grid\\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]) ?>
</div>
