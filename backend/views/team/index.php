<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '团队信息管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="team-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>此处一般只有一条团队记录，如需修改请点击操作中的“编辑”。</p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'team_id',
            'team_name',
            'project_topic',
            'division_work:ntext',
            'create_time',
            [
                'class' => 'yii\\grid\\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]) ?>
</div>
