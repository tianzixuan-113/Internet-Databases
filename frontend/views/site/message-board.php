<?php

/* @var $this yii\web\View */
/* @var $model common\models\MessageBoard */
/* @var $messages common\models\MessageBoard[] */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '留言板 · 抗战胜利 80 周年';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-message-board">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>欢迎在这里留下你对抗战历史、英雄先烈或本项目的感想与祝福。</p>

    <div class="row">
        <div class="col-md-5">
            <h3>我要留言</h3>
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'content')->textarea(['rows' => 4]) ?>

            <div class="form-group">
                <?= Html::submitButton('提交留言', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-7">
            <h3>历史留言</h3>
            <?php if ($messages): ?>
                <ul class="list-unstyled">
                    <?php foreach ($messages as $m): ?>
                        <li style="margin-bottom:12px;">
                            <strong><?= Html::encode($m->nickname) ?></strong>
                            <?php if ($m->msg_time): ?>
                                <span class="text-muted" style="margin-left:6px;">[<?= Html::encode($m->msg_time) ?>]</span>
                            <?php endif; ?>
                            <br>
                            <?= Html::encode($m->content) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>暂时还没有留言，成为第一个留言的人吧！</p>
            <?php endif; ?>
        </div>
    </div>
</div>
