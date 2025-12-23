<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '成员管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="member-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增成员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'member_id',
            'member_name',
            'student_id',
            'duty',
            'team_id',
            [
                'class' => 'yii\\grid\\ActionColumn',
            ],
        ],
    ]) ?>
</div>
