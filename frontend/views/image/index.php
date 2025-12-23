<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $images common\models\ImageResource[] */
/* @var $keyword string */

$this->title = '图片资源';
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
    
    .search-container {
        background: white;
        padding: 45px; /* 进一步增大内边距 */
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }
    
    .image-card {
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-bottom: 30px;
        background: white;
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .image-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.1);
    }
    
    .image-container {
        height: 250px; /* 保持图片容器高度 */
        overflow: hidden;
        position: relative;
    }
    
    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .image-container:hover img {
        transform: scale(1.05);
    }
    
    .image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 30px 15px 10px; /* 进一步增大内边距 */
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }
    
    .image-container:hover .image-overlay {
        transform: translateY(0);
    }
    
    .image-content {
        padding: 35px; /* 进一步增大内边距 */
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .image-description {
        flex-grow: 1;
    }
    
    .image-time {
        color: var(--gray-color);
        font-size: 1.5rem; /* 进一步增大时间字体 */
        margin-top: 25px; /* 进一步增大间距 */
        padding-top: 20px; /* 进一步增大间距 */
        border-top: 1px solid #eee;
        display: flex;
        align-items: center;
    }
    
    .image-time i {
        margin-right: 5px;
        color: var(--primary-color);
    }
    
    .btn-search {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 18px 35px; /* 进一步增加内边距 */
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(139, 0, 0, 0.2);
        font-size: 1.6rem; /* 进一步增大按钮字体 */
    }
    
    .btn-search:hover {
        background: #a52a2a;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(139, 0, 0, 0.3);
    }
    
    .btn-search i {
        margin-right: 8px;
    }
    
    .btn-clear {
        background: var(--secondary-color);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 18px 35px; /* 进一步增加内边距 */
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(44, 62, 80, 0.2);
        font-size: 1.6rem; /* 进一步增大按钮字体 */
    }
    
    .btn-clear:hover {
        background: #34495e;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(44, 62, 80, 0.3);
    }
    
    .form-control {
        border-radius: 50px;
        padding: 18px 35px; /* 进一步增加内边距 */
        border: 2px solid #e9ecef;
        transition: all 0.3s;
        font-size: 1.6rem; /* 进一步增大输入框字体 */
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(139, 0, 0, 0.25);
    }
    
    .result-info {
        background: #f8f9fa;
        padding: 30px; /* 进一步增大内边距 */
        border-radius: var(--border-radius);
        margin: 35px 0;
        text-align: center;
        border-left: 5px solid var(--primary-color);
        font-size: 1.6rem; /* 进一步增大结果信息字体 */
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
    
    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-color);
    }
    
    .search-form-container {
        position: relative;
    }
    
    .search-form-container .form-control {
        padding-left: 65px; /* 进一步增加左边距 */
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
    
    .image-description h5 {
        font-size: 1.8rem; /* 进一步增大图片描述字体 */
    }
    
    .alert {
        font-size: 1.6rem; /* 进一步增大提示框字体 */
    }
</style>

<div class="image-resource-index">
    <div class="minimal-hero">
        <div class="container">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="lead">浏览和搜索抗战历史图片资源</p>
        </div>
    </div>

    <div class="container">
        <div class="section-intro">
            <h2>历史影像</h2>
            <p>珍贵的历史照片和图片资料，记录了抗战时期的重要时刻和英雄事迹，让我们通过这些影像回顾那段难忘的历史</p>
        </div>
        
        <!-- 搜索表单 -->
        <div class="search-container">
            <div class="d-flex align-items-center mb-4">
                <div class="icon-box">
                    <i class="glyphicon glyphicon-search"></i>
                </div>
                <h3 class="mb-0" style="font-size: 2rem;">图片搜索</h3>
            </div>
            
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['image/search'],
                'options' => [
                    'class' => 'mb-0'
                ]
            ]); ?>
            
            <div class="search-form-container">
                <i class="glyphicon glyphicon-search search-icon"></i>
                <?= Html::textInput('keyword', isset($keyword) ? $keyword : '', ['class' => 'form-control form-control-lg', 'placeholder' => '输入关键词搜索图片描述...']) ?>
            </div>
            
            <div class="d-flex mt-3" style="gap: 25px;"> <!-- 进一步增大间距 -->
                <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> 搜索', ['class' => 'btn btn-search']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-refresh"></i> 清除', ['image/index'], ['class' => 'btn btn-clear']) ?>
            </div>
            
            <?php ActiveForm::end(); ?>
        </div>
        
        <?php if (!empty($keyword)): ?>
            <div class="result-info">
                <h4 style="font-size: 1.8rem;"><i class="glyphicon glyphicon-filter"></i> 搜索"<?= Html::encode($keyword) ?>"的结果：</h4>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($images)): ?>
            <div class="row">
                <?php foreach ($images as $image): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="image-card h-100">
                            <div class="image-container">
                                <?php if (!empty($image->img_url)): ?>
                                    <img src="<?= Html::encode($image->img_url) ?>" alt="<?= Html::encode($image->img_desc) ?>" title="<?= Html::encode($image->img_desc) ?>">
                                    <div class="image-overlay">
                                        <h5 class="mb-0" style="font-size: 1.5rem;"><?= Html::encode(mb_substr($image->img_desc, 0, 40)) ?><?= mb_strlen($image->img_desc) > 40 ? '...' : '' ?></h5>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center" style="height: 100%; background-color: #eee; color: #6c757d;">
                                        <div class="text-center">
                                            <i class="glyphicon glyphicon-picture" style="font-size: 4.5rem; display: block; margin-bottom: 20px;"></i>
                                            <span style="font-size: 1.6rem;">暂无图片</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="image-content">
                                <div class="image-description">
                                    <h5 class="mb-3" style="font-size: 1.8rem;"><?= Html::encode($image->img_desc) ?></h5>
                                </div>
                                <?php if (!empty($image->upload_time)): ?>
                                    <div class="image-time">
                                        <i class="glyphicon glyphicon-time"></i> 上传时间: <?= $image->upload_time ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="alert alert-light text-center mt-4">
                <h5 style="font-size: 1.8rem;"><i class="glyphicon glyphicon-info-sign"></i> 共找到 <?= count($images) ?> 张图片</h5>
            </div>
        <?php else: ?>
            <div class="alert alert-light text-center">
                <h4 style="font-size: 1.8rem;"><i class="glyphicon glyphicon-info-sign"></i> 没有找到匹配的图片资源</h4>
                <p style="font-size: 1.6rem;">请尝试使用其他关键词进行搜索。</p>
            </div>
        <?php endif; ?>
    </div>
</div>