<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WarCampaign */

$this->title = $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => '战役历史', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="campaign-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">战役信息</h3>
                </div>
                <div class="panel-body">
                    <p><strong>战役名称：</strong> <?= Html::encode($model->campaign_name) ?></p>
                    <p><strong>时间：</strong> 
                        <?= $model->start_time ?> 
                        <?php if ($model->end_time): ?> 
                            至 <?= $model->end_time ?> 
                        <?php endif; ?>
                    </p>
                    <p><strong>地点：</strong> <?= Html::encode($model->location) ?></p>
                    <p><strong>参战方：</strong> <?= Html::encode($model->warring_parties) ?></p>
                    <p><strong>结果：</strong> <?= Html::encode($model->result) ?></p>
                    <p><strong>描述：</strong> <?= Html::encode($model->description) ?></p>
                </div>
            </div>
        </div>
    </div>

    <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
</div>