<?php

/* @var $this yii\web\View */
/* @var $team common\models\TeamInfo|null */
/* @var $members common\models\MemberInfo[] */
/* @var $campaigns common\models\WarCampaign[] */
/* @var $news common\models\PublishInfo[] */
/* @var $messages common\models\MessageBoard[] */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = '抗战胜利80周年 · 团队主页';
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
        padding: 5rem 0;
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
    
    .btn-minimal.btn-dark {
        background: var(--secondary-color);
        color: white;
        border-color: var(--secondary-color);
    }
    
    .btn-minimal.btn-dark:hover {
        background: white;
        color: var(--secondary-color);
    }
    
    .campaign-item {
        padding: 30px; /* 进一步增加内边距 */
        border-radius: 10px;
        background: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        margin-bottom: 15px;
        border-left: 4px solid var(--primary-color);
        transition: var(--transition);
        font-size: 1.6rem; /* 进一步增大内容字体 */
    }
    
    .campaign-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }
    
    .message-item {
        padding: 30px; /* 进一步增加内边距 */
        border-radius: 10px;
        background: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        margin-bottom: 15px;
        border-left: 4px solid var(--success-color);
        transition: var(--transition);
        font-size: 1.6rem; /* 进一步增大内容字体 */
    }
    
    .message-item:hover {
        background: #f8fff9;
        transform: translateX(5px);
    }
    
    .news-card {
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
    }
    
    .news-card .card-body {
        padding: 35px; /* 进一步增加内边距 */
        font-size: 1.6rem; /* 进一步增大内容字体 */
    }
    
    .news-date {
        display: inline-block;
        background: var(--primary-color);
        color: white;
        padding: 10px 25px; /* 进一步增加内边距 */
        border-radius: 20px;
        font-size: 1.5rem; /* 进一步增大日期标签字体 */
        margin-bottom: 15px;
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
    
    .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        margin-right: 10px;
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
    
    .team-intro {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        padding: 55px 20px; /* 进一步增加内边距 */
        border-radius: var(--border-radius);
        margin-bottom: 30px;
    }
    
    .team-intro h3 {
        color: var(--secondary-color);
        margin-bottom: 15px;
        font-size: 2.5rem; /* 进一步增大介绍标题 */
    }
    
    .team-intro p {
        color: var(--gray-color);
        line-height: 1.8;
        font-size: 1.8rem; /* 进一步增大介绍文字 */
    }
    
    .btn-group-minimal {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 25px; /* 进一步增大间距 */
        margin-top: 30px;
    }
    
    .card-title {
        font-size: 1.8rem; /* 进一步增大卡片标题 */
    }
    
    .card-text {
        font-size: 1.6rem; /* 进一步增大卡片文字 */
    }
    
    .text-muted {
        font-size: 1.5rem; /* 进一步增大辅助文字 */
    }
</style>

<div class="site-index">
    <div class="minimal-hero">
        <div class="container">
            <h1>抗战胜利 80 周年</h1>
            <p class="lead">铭记历史 · 缅怀先烈 · 珍爱和平</p>
            <?php if ($team): ?>
                <p class="mt-4 text-dark" style="font-size: 1.8rem;">
                    <strong>项目团队：</strong>
                    <?= Html::encode($team->team_name) ?>
                    （主题：<?= Html::encode($team->project_topic) ?>）
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-book"></i>
                    </div>
                    <div class="stat-number"><?= count($campaigns) ?></div>
                    <div class="stat-title">重要战役</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-globe"></i>
                    </div>
                    <div class="stat-number"><?= count($news) ?></div>
                    <div class="stat-title">发布资讯</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-comment"></i>
                    </div>
                    <div class="stat-number"><?= count($messages) ?></div>
                    <div class="stat-title">用户留言</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-picture"></i>
                    </div>
                    <div class="stat-number">10</div>
                    <div class="stat-title">历史图片</div>
                </div>
            </div>
        </div>

        <div class="team-intro">
            <h3 class="text-center">项目介绍</h3>
            <p class="text-center">本项目致力于通过数字化手段记录和展示中国人民抗日战争的光辉历史，缅怀在抗战中英勇献身的英烈和所有为抗日战争作出贡献的人们。</p>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <h2 class="section-title">抗战重要战役</h2>
                <div class="timeline">
                    <?php if ($campaigns): ?>
                        <?php 
                        // 只显示前四条战役记录
                        $limited_campaigns = array_slice($campaigns, 0, 4);
                        foreach ($limited_campaigns as $c): 
                        ?>
                            <div class="timeline-item">
                                <h4 class="mb-1" style="font-size: 1.8rem;"><?= Html::encode($c->campaign_name) ?></h4>
                                <?php if ($c->start_time): ?>
                                    <p class="text-muted mb-1" style="font-size: 1.5rem;">
                                        <i class="glyphicon glyphicon-time"></i> 
                                        <?= Html::encode($c->start_time) ?> 
                                        <?php if ($c->end_time): ?> 
                                            至 <?= Html::encode($c->end_time) ?> 
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ($c->location): ?>
                                    <p class="mb-0" style="font-size: 1.5rem;"><i class="glyphicon glyphicon-map-marker"></i> <?= Html::encode($c->location) ?></p>
                                <?php endif; ?>
                                <?php if ($c->result): ?>
                                    <p style="font-size: 1.5rem;"><i class="glyphicon glyphicon-flag"></i> <?= Html::encode($c->result) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-light text-center" style="font-size: 1.6rem;">暂未录入战役信息</div>
                    <?php endif; ?>
                </div>
                
                <!-- 添加'查看更多'按钮 -->
                <div class="text-center mt-4">
                    <?= Html::a('<i class="glyphicon glyphicon-th-list"></i> 查看全部战役', ['campaign/index'], ['class' => 'btn btn-minimal']) ?>
                </div>
            </div>
            
            <div class="col-lg-6">
                <h2 class="section-title">团队发布 · 资讯</h2>
                <div id="news-container">
                    <?php if ($news): ?>
                        <?php 
                        // 只显示最近两条资讯
                        $limited_news = array_slice($news, 0, 2);
                        foreach ($limited_news as $n): 
                        ?>
                            <div class="card news-card">
                                <div class="card-body">
                                    <div class="news-date">
                                        <i class="glyphicon glyphicon-calendar"></i> <?= Html::encode($n->publish_time) ?>
                                    </div>
                                    <h5 class="card-title fw-bold" style="font-size: 1.8rem;"><?= Html::encode($n->title) ?></h5>
                                    <p class="card-text text-muted" style="font-size: 1.6rem;"><?= Html::encode(mb_substr($n->content, 0, 100)) ?><?= mb_strlen($n->content) > 100 ? '...' : '' ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted" style="font-size: 1.4rem;">
                                            <i class="glyphicon glyphicon-user"></i> 发布者
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (count($news) > 2): ?>
                            <!-- 显示剩余的资讯（初始隐藏） -->
                            <div id="more-news" style="display: none;">
                                <?php 
                                $remaining_news = array_slice($news, 2);
                                foreach ($remaining_news as $n): 
                                ?>
                                    <div class="card news-card">
                                        <div class="card-body">
                                            <div class="news-date">
                                                <i class="glyphicon glyphicon-calendar"></i> <?= Html::encode($n->publish_time) ?>
                                            </div>
                                            <h5 class="card-title fw-bold" style="font-size: 1.8rem;"><?= Html::encode($n->title) ?></h5>
                                            <p class="card-text text-muted" style="font-size: 1.6rem;"><?= Html::encode(mb_substr($n->content, 0, 100)) ?><?= mb_strlen($n->content) > 100 ? '...' : '' ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted" style="font-size: 1.4rem;">
                                                    <i class="glyphicon glyphicon-user"></i> 发布者
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-light text-center" style="font-size: 1.6rem;">暂未发布资讯内容</div>
                    <?php endif; ?>
                </div>
                
                <?php if (count($news) > 2): ?>
                    <!-- 调整按钮位置，使其与左边按钮平行 -->
                    <div class="text-center mt-4">
                        <button class="btn btn-minimal" id="toggle-news" onclick="toggleNews()">
                            <i class="glyphicon glyphicon-chevron-down"></i> 展开更多资讯
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- 在两个按钮下方添加分隔线 -->
        <div class="divider-line" style="margin: 30px 0; border-bottom: 1px solid #e9ecef;"></div>

        <div class="btn-group-minimal">
            <?= Html::a('<i class="glyphicon glyphicon-user"></i> 团队介绍', ['team/index'], ['class' => 'btn btn-minimal']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-search"></i> 搜索数据', ['search/index'], ['class' => 'btn btn-minimal']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-picture"></i> 图片资源', ['image/index'], ['class' => 'btn btn-minimal']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-comment"></i> 留言板', ['message/index'], ['class' => 'btn btn-minimal']) ?>
        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <h2 class="section-title">最新留言</h2>
                <div id="messages-container">
                    <?php if ($messages): ?>
                        <div class="row" id="recent-messages">
                            <?php 
                            // 只显示最近4条留言
                            $limited_messages = array_slice($messages, 0, 4);
                            foreach ($limited_messages as $m): 
                            ?>
                                <div class="col-md-6">
                                    <div class="message-item">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-0" style="font-size: 1.6rem;">
                                                <i class="glyphicon glyphicon-user"></i>
                                                <?= Html::encode($m->nickname) ?>
                                            </h5>
                                            <small class="text-muted" style="font-size: 1.5rem;">
                                                <i class="glyphicon glyphicon-time"></i>
                                                <?= Html::encode($m->msg_time) ?>
                                            </small>
                                        </div>
                                        <p class="mt-2 mb-0" style="font-size: 1.6rem;"><?= Html::encode($m->content) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if (count($messages) > 4): ?>
                            <!-- 显示剩余的留言（初始隐藏） -->
                            <div class="row" id="more-messages" style="display: none;">
                                <?php 
                                $remaining_messages = array_slice($messages, 4);
                                foreach ($remaining_messages as $m): 
                                ?>
                                    <div class="col-md-6">
                                        <div class="message-item">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="mb-0" style="font-size: 1.6rem;">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                    <?= Html::encode($m->nickname) ?>
                                                </h5>
                                                <small class="text-muted" style="font-size: 1.5rem;">
                                                    <i class="glyphicon glyphicon-time"></i>
                                                    <?= Html::encode($m->msg_time) ?>
                                                </small>
                                            </div>
                                            <p class="mt-2 mb-0" style="font-size: 1.6rem;"><?= Html::encode($m->content) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- 更改为跳转到留言板的按钮 -->
                            <div class="text-center mt-4">
                                <?= Html::a('<i class="glyphicon glyphicon-comment"></i> 查看更多', ['message/index'], ['class' => 'btn btn-minimal btn-dark']) ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-light text-center" style="font-size: 1.6rem;">
                            <p>还没有留言，快来留下你的祝福吧！</p>
                            <?= Html::a('前往留言板', ['message/index'], ['class' => 'btn btn-minimal btn-dark']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleNews() {
    const moreNews = document.getElementById('more-news');
    const toggleBtn = document.getElementById('toggle-news');
    
    if (moreNews.style.display === 'none') {
        // 展开
        moreNews.style.display = 'block';
        toggleBtn.innerHTML = '<i class="glyphicon glyphicon-chevron-up"></i> 收起资讯';
    } else {
        // 收起
        moreNews.style.display = 'none';
        toggleBtn.innerHTML = '<i class="glyphicon glyphicon-chevron-down"></i> 展开更多资讯';
    }
}

function toggleMessages() {
    const moreMessages = document.getElementById('more-messages');
    const toggleMsgBtn = document.getElementById('toggle-messages');
    
    if (moreMessages.style.display === 'none') {
        // 展开
        moreMessages.style.display = 'block';
        toggleMsgBtn.innerHTML = '<i class="glyphicon glyphicon-chevron-up"></i> 收起留言';
    } else {
        // 收起
        moreMessages.style.display = 'none';
        toggleMsgBtn.innerHTML = '<i class="glyphicon glyphicon-chevron-down"></i> 展开更多留言';
    }
}
</script>