<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $campaigns common\models\WarCampaign[] */

$this->title = '战役历史';
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
        padding: 35px; /* 进一步增大内边距 */
        text-align: center;
        border-bottom: 1px solid #eee;
    }
    
    .campaign-body {
        padding: 35px; /* 进一步增大内边距 */
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
    
    .stat-card {
        text-align: center;
        padding: 35px 15px; /* 进一步增加内边距 */
        border-radius: var(--border-radius);
        background: white;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        font-size: 3.5rem; /* 进一步增大图标字体 */
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    
    .stat-number {
        font-size: 3.5rem; /* 进一步增大统计数字 */
        font-weight: 700;
        color: var(--secondary-color);
    }
    
    .stat-title {
        font-size: 1.8rem; /* 进一步增大统计标题 */
        color: var(--gray-color);
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
    
    .timeline {
        position: relative;
        padding-left: 30px;
        margin-left: 10px;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: var(--primary-color);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -33px;
        top: 5px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--primary-color);
        border: 3px solid white;
        box-shadow: 0 0 0 2px var(--primary-color);
    }
    
    .timeline-content {
        padding: 25px; /* 进一步增大内边距 */
        border-radius: var(--border-radius);
        background: white;
        box-shadow: var(--box-shadow);
        font-size: 1.6rem; /* 进一步增大时间线内容字体 */
    }
    
    .timeline-title {
        font-size: 1.8rem; /* 进一步增大时间线标题字体 */
        margin-bottom: 10px;
    }
</style>

<div class="war-campaign-index">
    <div class="minimal-hero">
        <div class="container">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="lead">了解抗战期间的重要战役</p>
        </div>
    </div>

    <div class="container">
        <div class="section-intro">
            <h2>战役概览</h2>
            <p>中国人民抗日战争是中华民族历史上最伟大的卫国战争，这些战役记录了中华民族抵抗侵略的英勇事迹，展示了中国人民不屈不挠的精神。</p>
        </div>
        
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-book"></i>
                    </div>
                    <div class="stat-number"><?= count($campaigns) ?></div>
                    <div class="stat-title">总战役数</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-globe"></i>
                    </div>
                    <div class="stat-number"><?= count(array_filter($campaigns, function($c) { return $c->result && strpos($c->result, '胜') !== false; })) ?></div>
                    <div class="stat-title">胜利战役</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-map-marker"></i>
                    </div>
                    <div class="stat-number"><?= count(array_unique(array_column($campaigns, 'location'))) ?></div>
                    <div class="stat-title">不同地区</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-time"></i>
                    </div>
                    <div class="stat-number">
                        <?php
                            if ($campaigns) {
                                $start_times = array_map(function($c) { 
                                    return $c->start_time ? $c->start_time : null; 
                                }, $campaigns);
                                $start_times = array_filter($start_times); // 过滤掉null值
                                
                                $end_times = array_map(function($c) { 
                                    return $c->end_time ? $c->end_time : null; 
                                }, $campaigns);
                                $end_times = array_filter($end_times); // 过滤掉null值
                                
                                if (empty($start_times)) {
                                    echo 0;
                                } else {
                                    $earliest_start = min($start_times);
                                    $latest_end = !empty($end_times) ? max($end_times) : $earliest_start;
                                    
                                    // 确保日期格式正确
                                    $start_timestamp = strtotime($earliest_start);
                                    $end_timestamp = strtotime($latest_end);
                                    
                                    // 计算年数差
                                    $diff_seconds = $end_timestamp - $start_timestamp;
                                    $years = $diff_seconds / (365.25 * 24 * 60 * 60); // 每年平均秒数
                                    
                                    echo round(abs($years), 1); // 使用绝对值并保留一位小数
                                }
                            } else {
                                echo 0;
                            }
                        ?>
                    </div>
                    <div class="stat-title">抗战年数</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box">
                        <i class="glyphicon glyphicon-list"></i>
                    </div>
                    <h3 class="mb-0" style="font-size: 2rem;">战役时间线</h3>
                </div>
                
                <div class="timeline">
                    <?php if ($campaigns): ?>
                        <?php foreach ($campaigns as $c): ?>
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <h4 class="timeline-title" style="font-size: 2rem;"><?= Html::encode($c->campaign_name) ?></h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p style="font-size: 1.5rem;"><i class="glyphicon glyphicon-calendar"></i> <strong>开始时间：</strong> <?= Html::encode($c->start_time) ?></p>
                                            <p style="font-size: 1.5rem;"><i class="glyphicon glyphicon-map-marker"></i> <strong>地点：</strong> <?= Html::encode($c->location) ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p style="font-size: 1.5rem;"><i class="glyphicon glyphicon-flag"></i> <strong>结果：</strong> <?= Html::encode($c->result) ?></p>
                                            <?php if ($c->end_time): ?>
                                                <p style="font-size: 1.5rem;"><i class="glyphicon glyphicon-time"></i> <strong>结束时间：</strong> <?= Html::encode($c->end_time) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if ($c->description): ?>
                                        <p style="font-size: 1.5rem;"><i class="glyphicon glyphicon-info-sign"></i> <strong>描述：</strong> <?= Html::encode(mb_substr($c->description, 0, 150)) ?><?= mb_strlen($c->description) > 150 ? '...' : '' ?></p>
                                    <?php endif; ?>
                                    <?= Html::a('查看详情', ['campaign/view', 'id' => $c->campaign_id], ['class' => 'btn btn-minimal']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-light text-center" style="font-size: 1.6rem;">暂未录入战役信息</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>