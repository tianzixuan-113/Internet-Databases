<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MessageBoard */
/* @var $messages common\models\MessageBoard[] */

$this->title = '留言板';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    :root {
        --primary-color: #8B0000;
        --secondary-color: #2c3e50;
        --accent-color: #d35400;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --gray-color: #6c757d;
        --success-color: #27ae60;
        --border-radius: 12px;
        --box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        --transition: all 0.3s ease;
    }
    
    .minimal-hero {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        padding: 4rem 0;
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    
    .minimal-hero:after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        height: 100px;
        background: url('data:image.svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="1" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,261.3C672,256,768,224,864,197.3C960,171,1056,149,1152,149.3C1248,149,1344,171,1392,181.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-size: cover;
        background-repeat: no-repeat;
    }
    
    .minimal-hero h1 {
        font-size: 4.5rem; /* 进一步增大标题字体 */
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .minimal-hero p.lead {
        font-size: 2.5rem; /* 进一步增大副标题字体 */
        color: var(--gray-color);
        max-width: 700px;
        margin: 0 auto 2rem;
    }
    
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 30px;
        color: var(--secondary-color);
        font-weight: 700;
        font-size: 3rem; /* 进一步增大标题字体 */
        text-align: center;
    }
    
    .section-title:after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }
    
    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-bottom: 25px;
        background: white;
        transition: var(--transition);
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.1);
    }
    
    .message-form-container {
        background: white;
        padding: 45px; /* 进一步增大内边距 */
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-bottom: 40px;
    }
    
    .form-group label {
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 8px;
        font-size: 1.8rem; /* 进一步增大表单标签字体 */
    }
    
    .form-control {
        border-radius: 8px;
        padding: 18px 25px; /* 进一步增大内边距 */
        border: 1px solid #e9ecef;
        transition: all 0.3s;
        font-size: 1.6rem; /* 进一步增大输入框字体 */
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(139, 0, 0, 0.25);
    }
    
    .btn-submit {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 18px 35px; /* 进一步增大内边距 */
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(139, 0, 0, 0.2);
        width: 100%;
        font-size: 1.8rem; /* 进一步增大提交按钮字体 */
    }
    
    .btn-submit:hover {
        background: #a52a2a;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(139, 0, 0, 0.3);
    }
    
    .btn-submit i {
        margin-right: 8px;
    }
    
    .message-item {
        padding: 35px; /* 进一步增大内边距 */
        border-radius: var(--border-radius);
        background: white;
        box-shadow: var(--box-shadow);
        margin-bottom: 30px; /* 进一步增大间距 */
        border-left: 4px solid var(--success-color);
        transition: var(--transition);
        font-size: 1.6rem; /* 进一步增大留言项字体 */
    }
    
    .message-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    
    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .message-nickname {
        font-weight: 600;
        color: var(--secondary-color);
        font-size: 1.8rem; /* 进一步增大昵称字体 */
    }
    
    .message-time {
        color: var(--gray-color);
        font-size: 1.5rem; /* 进一步增大时间字体 */
    }
    
    .message-content {
        color: #555;
        line-height: 1.7;
        font-size: 1.6rem; /* 进一步增大留言内容字体 */
    }
    
    .section-intro {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .section-intro h2 {
        font-size: 2.8rem; /* 进一步增大标题字体 */
        color: var(--secondary-color);
        margin-bottom: 15px;
    }
    
    .section-intro p {
        color: var(--gray-color);
        font-size: 1.8rem; /* 进一步增大介绍文字 */
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.8;
    }
    
    .icon-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px; /* 进一步增大图标框 */
        height: 60px; /* 进一步增大图标框 */
        border-radius: 12px;
        background: var(--primary-color);
        color: white;
        font-size: 2.2rem; /* 进一步增大图标字体 */
        margin-right: 15px;
    }
    
    .alert {
        font-size: 1.6rem; /* 进一步增大提示框字体 */
    }
    
    .fixed-element {
        position: -webkit-sticky;
        position: sticky;
        top: 20px;
        z-index: 100;
    }
</style>

<div class="message-board-index">
    <div class="minimal-hero">
        <div class="container">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="lead">留下你的感想与祝福</p>
        </div>
    </div>

    <div class="container">
        <div class="section-intro">
            <h2>抗战留言</h2>
            <p>在这里，您可以留下对抗战英雄的敬意，对和平的祝愿，以及对历史的感悟。让我们共同铭记历史，珍爱和平。</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="message-form-container" style="position: -webkit-sticky; position: sticky; top: 20px;">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </div>
                        <h3 class="mb-0" style="font-size: 2rem;">发表留言</h3>
                    </div>
                    
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="form-group">
                        <?= $form->field($model, 'nickname')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => '输入昵称'])->label('昵称') ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'form-control', 'placeholder' => '输入留言内容'])->label('留言内容') ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> 提交留言', ['class' => 'btn btn-submit']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box">
                        <i class="glyphicon glyphicon-comment"></i>
                    </div>
                    <h3 class="mb-0" style="font-size: 2rem;">最新留言</h3>
                </div>
                
                <?php if (!empty($messages)): ?>
                    <div class="messages-container">
                        <?php foreach ($messages as $message): ?>
                            <div class="message-item">
                                <div class="message-header">
                                    <div class="message-nickname">
                                        <i class="glyphicon glyphicon-user"></i> <?= Html::encode($message->nickname) ?>
                                    </div>
                                    <div class="message-time">
                                        <i class="glyphicon glyphicon-time"></i> <?= $message->msg_time ?>
                                    </div>
                                </div>
                                <div class="message-content">
                                    <?= Html::encode($message->content) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-light text-center">
                        <h5 style="font-size: 1.8rem;"><i class="glyphicon glyphicon-info-sign"></i> 暂无留言</h5>
                        <p style="font-size: 1.6rem;">还没有留言，快来留下你的祝福吧！</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
</div>