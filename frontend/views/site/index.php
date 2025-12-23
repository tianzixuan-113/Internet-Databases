<?php

/* @var $this yii\web\View */
/* @var $team common\models\TeamInfo|null */
/* @var $members common\models\MemberInfo[] */
/* @var $campaigns common\models\WarCampaign[] */
/* @var $news common\models\PublishInfo[] */
/* @var $messages common\models\MessageBoard[] */

use yii\helpers\Html;

$this->title = '烽火记忆｜首页';
?>

<div class="site-index" style="margin-top:16px;">
    <div class="hero-banner">
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1600&auto=format&fit=crop');"></div>
        <div class="overlay"></div>
        <div class="content">
            <h1>丰碑永铸 · 铭刻与传承</h1>
            <p>以史为鉴，开创未来。庄重而不失温度的纪念空间。</p>
        </div>
    </div>

    <div class="home-grid">
        <div class="home-card">
            <div class="icon"><i class="fa-solid fa-map"></i></div>
            <div class="title">烽火岁月</div>
            <div class="desc">全景式回顾重大战役与历史事件脉络，重现那段不屈的历程。</div>
            <?= Html::a('进入', ['#'], ['class' => 'link']) ?>
        </div>
        <div class="home-card">
            <div class="icon"><i class="fa-solid fa-star"></i></div>
            <div class="title">英魂不朽</div>
            <div class="desc">铭记英雄事迹与感人故事，传承伟大的抗战精神。</div>
            <?= Html::a('进入', ['#'], ['class' => 'link']) ?>
        </div>
        <div class="home-card">
            <div class="icon"><i class="fa-solid fa-landmark"></i></div>
            <div class="title">文物证史</div>
            <div class="desc">通过珍贵文物、史料文献，触摸真实的历史温度。</div>
            <?= Html::a('进入', ['#'], ['class' => 'link']) ?>
        </div>
        <div class="home-card">
            <div class="icon"><i class="fa-solid fa-map-location-dot"></i></div>
            <div class="title">血色山河</div>
            <div class="desc">可视化展示主要战役地点、抗日根据地与历史轨迹。</div>
            <?= Html::a('进入', ['#'], ['class' => 'link']) ?>
        </div>
        <div class="home-card">
            <div class="icon"><i class="fa-solid fa-handshake"></i></div>
            <div class="title">精神传承</div>
            <div class="desc">展现新时代纪念活动、文艺作品与爱国主义教育成果。</div>
            <?= Html::a('进入', ['#'], ['class' => 'link']) ?>
        </div>
        <div class="home-card">
            <div class="icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
            <div class="title">吾辈自强</div>
            <div class="desc">历史启示与时代回响。铭记历史，珍爱和平，共创未来。</div>
            <?= Html::a('进入', ['#'], ['class' => 'link']) ?>
        </div>
    </div>
</div>
