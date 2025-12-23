<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WarCampaign */

$this->title = $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => '战役历史', 'url' => ['index']];
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
    
    .campaign-card {
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-bottom: 30px;
        background: white;
        transition: var(--transition);
        overflow: hidden;
    }
    
    .campaign-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.1);
    }
    
    .campaign-header {
        background: white;
        padding: 45px; /* 进一步增大内边距 */
        text-align: center;
        border-bottom: 1px solid #eee;
    }
    
    .campaign-body {
        padding: 45px; /* 进一步增大内边距 */
    }
    
    .info-item {
        margin-bottom: 35px; /* 进一步增大间距 */
        padding-bottom: 35px; /* 进一步增大间距 */
        border-bottom: 1px solid #eee;
    }
    
    .info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .info-label {
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        font-size: 1.8rem; /* 进一步增大标签字体 */
    }
    
    .info-label i {
        margin-right: 10px;
        color: var(--primary-color);
        width: 24px;
        text-align: center;
    }
    
    .info-value {
        padding-left: 34px;
        color: #555;
        line-height: 1.7;
        font-size: 1.6rem; /* 进一步增大内容字体 */
    }
    
    .btn-minimal {
        background: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: 50px;
        padding: 18px 35px; /* 进一步增加按钮内边距 */
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(139, 0, 0, 0.1);
        font-size: 1.6rem; /* 进一步增大按钮字体 */
    }
    
    .btn-minimal:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(139, 0, 0, 0.2);
    }
    
    .btn-minimal i {
        margin-right: 8px;
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
</style>

<div class="war-campaign-view">
    <div class="minimal-hero">
        <div class="container">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="lead"><?= Html::encode($model->location) ?></p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="campaign-card">
                    <div class="campaign-header">
                        <h3 class="mb-0" style="font-size: 2rem;">
                            <i class="glyphicon glyphicon-info-sign"></i> 战役详情
                        </h3>
                    </div>
                    
                    <div class="campaign-body">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="glyphicon glyphicon-star"></i> 战役名称
                            </div>
                            <div class="info-value">
                                <h4 class="mb-0" style="font-size: 1.8rem;"><?= Html::encode($model->campaign_name) ?></h4>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="glyphicon glyphicon-map-marker"></i> 战役地点
                            </div>
                            <div class="info-value">
                                <p class="mb-0" style="font-size: 1.6rem;"><?= Html::encode($model->location) ?></p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="glyphicon glyphicon-time"></i> 开始时间
                            </div>
                            <div class="info-value">
                                <p class="mb-0" style="font-size: 1.6rem;"><?= Html::encode($model->start_time) ?></p>
                            </div>
                        </div>
                        
                        <?php if ($model->end_time): ?>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="glyphicon glyphicon-stop"></i> 结束时间
                            </div>
                            <div class="info-value">
                                <p class="mb-0" style="font-size: 1.6rem;"><?= Html::encode($model->end_time) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="glyphicon glyphicon-flag"></i> 战役结果
                            </div>
                            <div class="info-value">
                                <p class="mb-0" style="font-size: 1.6rem;"><?= Html::encode($model->result) ?></p>
                            </div>
                        </div>
                        
                        <?php if ($model->description): ?>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="glyphicon glyphicon-info-sign"></i> 战役描述
                            </div>
                            <div class="info-value">
                                <div style="font-size: 1.6rem;"><?= nl2br(Html::encode($model->description)) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mt-5 text-center">
                            <?= Html::a('返回战役列表', ['index'], ['class' => 'btn btn-minimal']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>