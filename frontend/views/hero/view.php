<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HeroInfo */

$this->title = $model->hero_name;
$this->params['breadcrumbs'][] = ['label' => '抗战英雄', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="hero-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">英雄信息</h3>
                </div>
                <div class="panel-body">
                    <p><strong>英雄姓名：</strong> <?= Html::encode($model->hero_name) ?></p>
                    <p><strong>籍贯：</strong> <?= Html::encode($model->native_place) ?></p>
                    <p><strong>所属军队：</strong> <?= Html::encode($model->army) ?></p>
                    <?php if ($model->campaign): ?>
                        <p><strong>参与战役：</strong> <?= Html::encode($model->campaign->campaign_name) ?></p>
                    <?php endif; ?>
                    <p><strong>事迹：</strong> <?= Html::encode($model->deed) ?></p>
                </div>
            </div>
        </div>
    </div>

    <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
</div>