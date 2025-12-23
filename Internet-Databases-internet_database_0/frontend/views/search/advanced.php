<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel yii\base\DynamicModel */
$this->title = '高级搜索';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="advanced-search">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'options' => ['class' => 'form-horizontal']
    ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">战役搜索</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'campaign_name')->textInput(['maxlength' => true, 'placeholder' => '战役名称']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'location')->textInput(['maxlength' => true, 'placeholder' => '战役地点']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'start_time_from')->input('date', ['placeholder' => '开始日期']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'start_time_to')->input('date', ['placeholder' => '结束日期']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">英雄搜索</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'hero_name')->textInput(['maxlength' => true, 'placeholder' => '英雄姓名']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'native_place')->textInput(['maxlength' => true, 'placeholder' => '英雄籍贯']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">文献搜索</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'doc_name')->textInput(['maxlength' => true, 'placeholder' => '文献名称']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'doc_type')->dropDownList([
                        '' => '全部类型',
                        '文件' => '文件',
                        '照片' => '照片',
                        '日记' => '日记',
                        '电报' => '电报',
                        '其他' => '其他'
                    ], ['prompt' => '选择文献类型']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('返回普通搜索', ['search/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <!-- 搜索结果 -->
    <div class="search-results">
        <!-- 战役结果 -->
        <?php if (!empty($campaigns)): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">战役搜索结果 (共<?= count($campaigns) ?>条)</h3>
                </div>
                <div class="panel-body">
                    <?php foreach ($campaigns as $campaign): ?>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><?= Html::encode($campaign->campaign_name) ?></h4>
                                <p><strong>时间：</strong> <?= $campaign->start_time ?> - <?= $campaign->end_time ?></p>
                                <p><strong>地点：</strong> <?= Html::encode($campaign->location) ?></p>
                                <p><strong>参战方：</strong> <?= Html::encode($campaign->warring_parties) ?></p>
                                <p><strong>结果：</strong> <?= Html::encode($campaign->result) ?></p>
                                <p><strong>描述：</strong> <?= Html::encode($campaign->description) ?></p>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 英雄结果 -->
        <?php if (!empty($heroes)): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">英雄搜索结果 (共<?= count($heroes) ?>条)</h3>
                </div>
                <div class="panel-body">
                    <?php foreach ($heroes as $hero): ?>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><?= Html::encode($hero->hero_name) ?></h4>
                                <p><strong>籍贯：</strong> <?= Html::encode($hero->native_place) ?></p>
                                <p><strong>所属军队：</strong> <?= Html::encode($hero->army) ?></p>
                                <p><strong>事迹：</strong> <?= Html::encode($hero->deed) ?></p>
                                <?php if ($hero->campaign): ?>
                                    <p><strong>参与战役：</strong> <?= Html::encode($hero->campaign->campaign_name) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 文献结果 -->
        <?php if (!empty($docs)): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">文献搜索结果 (共<?= count($docs) ?>条)</h3>
                </div>
                <div class="panel-body">
                    <?php foreach ($docs as $doc): ?>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><?= Html::encode($doc->doc_name) ?></h4>
                                <p><strong>类型：</strong> <?= Html::encode($doc->doc_type) ?></p>
                                <p><strong>摘要：</strong> <?= Html::encode($doc->doc_summary) ?></p>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($campaigns) && empty($heroes) && empty($docs) && $searchModel->validate()): ?>
            <div class="alert alert-info">没有找到匹配的结果。</div>
        <?php endif; ?>
    </div>
</div>