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

<div class="site-index">
    <div class="jumbotron">
        <h1>抗战胜利 80 周年</h1>
        <p class="lead">铭记历史 · 缅怀先烈 · 珍爱和平</p>
        <?php if ($team): ?>
            <p>
                <strong>项目团队：</strong>
                <?= Html::encode($team->team_name) ?>
                （主题：<?= Html::encode($team->project_topic) ?>）
            </p>
        <?php endif; ?>
        <p>
            <?= Html::a('查看团队与成员', ['site/index', '#' => 'team'], ['class' => 'btn btn-lg btn-primary']) ?>
            <?= Html::a('进入留言墙', ['site/message-board'], ['class' => 'btn btn-lg btn-success']) ?>
            <?= Html::a('搜索抗战数据', ['search/index'], ['class' => 'btn btn-lg btn-info']) ?>
        </p>
    </div>

    <div class="body-content">
        <div class="row" id="team">
            <div class="col-lg-6">
                <h2>团队介绍</h2>
                <?php if ($team): ?>
                    <p><strong>团队名称：</strong><?= Html::encode($team->team_name) ?></p>
                    <p><strong>项目主题：</strong><?= Html::encode($team->project_topic) ?></p>
                    <?php if ($team->division_work): ?>
                        <p><strong>团队分工：</strong><br><?= nl2br(Html::encode($team->division_work)) ?></p>
                    <?php endif; ?>
                    <?php if ($team->create_time): ?>
                        <p><strong>创建时间：</strong><?= Html::encode($team->create_time) ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>暂未录入团队信息。</p>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <h2>团队成员</h2>
                <?php if ($members): ?>
                    <ul class="list-unstyled">
                        <?php foreach ($members as $member): ?>
                            <li style="margin-bottom:8px;">
                                <strong><?= Html::encode($member->member_name) ?></strong>
                                （学号：<?= Html::encode($member->student_id) ?>，职责：<?= Html::encode($member->duty) ?>）
                                <?php if ($member->introduction): ?>
                                    <br><small><?= Html::encode($member->introduction) ?></small>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>暂未录入成员信息。</p>
                <?php endif; ?>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-6">
                <h2>抗战重要战役</h2>
                <?php if ($campaigns): ?>
                    <ul class="list-unstyled">
                        <?php foreach ($campaigns as $c): ?>
                            <li style="margin-bottom:10px;">
                                <strong><?= Html::encode($c->campaign_name) ?></strong>
                                <?php if ($c->start_time): ?>
                                    <span class="text-muted">（<?= Html::encode($c->start_time) ?><?= $c->end_time ? ' ~ ' . Html::encode($c->end_time) : '' ?>）</span>
                                <?php endif; ?>
                                <?php if ($c->location): ?>
                                    <br><small>地点：<?= Html::encode($c->location) ?></small>
                                <?php endif; ?>
                                <?php if ($c->result): ?>
                                    <br><small>结果：<?= Html::encode($c->result) ?></small>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>暂未录入战役信息。</p>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <h2>团队发布 · 资讯</h2>
                <?php if ($news): ?>
                    <ul class="list-unstyled">
                        <?php foreach ($news as $n): ?>
                            <li style="margin-bottom:10px;">
                                <strong><?= Html::encode($n->title) ?></strong>
                                <?php if ($n->publish_time): ?>
                                    <span class="text-muted">（<?= Html::encode($n->publish_time) ?>）</span>
                                <?php endif; ?>
                                <br>
                                <small><?= Html::encode(mb_substr($n->content, 0, 60)) ?><?= mb_strlen($n->content) > 60 ? '...' : '' ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>暂未发布资讯内容。</p>
                <?php endif; ?>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <h2>最新留言</h2>
                <?php if ($messages): ?>
                    <ul class="list-unstyled">
                        <?php foreach ($messages as $m): ?>
                            <li style="margin-bottom:8px;">
                                <strong><?= Html::encode($m->nickname) ?>：</strong>
                                <?= Html::encode($m->content) ?>
                                <?php if ($m->msg_time): ?>
                                    <span class="text-muted" style="margin-left:8px;">[<?= Html::encode($m->msg_time) ?>]</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p><?= Html::a('查看更多并留言 »', ['site/message-board'], ['class' => 'btn btn-default']) ?></p>
                <?php else: ?>
                    <p>还没有留言，快来留下你的祝福吧！</p>
                    <p><?= Html::a('前往留言板', ['site/message-board'], ['class' => 'btn btn-primary']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
