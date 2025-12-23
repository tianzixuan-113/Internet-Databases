<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HistoricalDoc */

$this->title = $model->doc_name;
$this->params['breadcrumbs'][] = ['label' => '史料文献', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="doc-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">文献信息</h3>
                </div>
                <div class="panel-body">
                    <p><strong>文献名称：</strong> <?= Html::encode($model->doc_name) ?></p>
                    <p><strong>类型：</strong> <?= Html::encode($model->doc_type) ?></p>
                    <p><strong>摘要：</strong> <?= Html::encode($model->doc_summary) ?></p>
                </div>
            </div>
        </div>
    </div>

    <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
</div>