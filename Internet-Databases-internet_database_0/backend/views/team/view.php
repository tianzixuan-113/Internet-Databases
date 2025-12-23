<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TeamInfo */

$this->title = $model->team_name;
$this->params['breadcrumbs'][] = ['label' => '团队管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="team-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->team_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->team_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该团队记录吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'team_id',
            'team_name',
            'leader',
            'contact_email:email',
            'description:ntext',
        ],
    ]) ?>
</div>
