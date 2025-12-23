<?php

/* @var $this yii\web\View */
/* @var $totals array */
/* @var $messagesLast7 int */
/* @var $messageTrend int|null */
/* @var $campaignByYear array */
/* @var $heroByCampaign array */
/* @var $visitTrend array */

use yii\helpers\Json;

$this->title = '抗战纪念数据仪表盘';

$campaignYearLabels = array_column($campaignByYear, 'year');
$campaignYearCounts = array_column($campaignByYear, 'count');

$heroCampaignLabels = array_column($heroByCampaign, 'campaign_id');
$heroCampaignCounts = array_column($heroByCampaign, 'count');

$visitLabels = array_column($visitTrend, 'day');
$visitCounts = array_column($visitTrend, 'count');
?>

<div class="dashboard">
    <div class="dashboard-row dashboard-row--top">
        <div class="metric-card metric-card--primary">
            <div class="metric-card__label">文物资料总数</div>
            <div class="metric-card__value"><?= (int)$totals['relics'] ?></div>
            <div class="metric-card__meta">涵盖重要抗战文物与藏品</div>
        </div>
        <div class="metric-card">
            <div class="metric-card__label">史料文献总数</div>
            <div class="metric-card__value"><?= (int)$totals['docs'] ?></div>
            <div class="metric-card__meta">战报、电报、回忆录等文献</div>
        </div>
        <div class="metric-card">
            <div class="metric-card__label">英雄人物数量</div>
            <div class="metric-card__value"><?= (int)$totals['heroes'] ?></div>
            <div class="metric-card__meta">关联典型战役与部队信息</div>
        </div>
        <div class="metric-card">
            <div class="metric-card__label">战役档案数量</div>
            <div class="metric-card__value"><?= (int)$totals['campaigns'] ?></div>
            <div class="metric-card__meta">覆盖重要战役节点</div>
        </div>
        <div class="metric-card">
            <div class="metric-card__label">近 7 日新增留言</div>
            <div class="metric-card__value"><?= (int)$messagesLast7 ?></div>
            <div class="metric-card__trend <?= $messageTrend === null ? '' : ($messageTrend >= 0 ? 'is-up' : 'is-down') ?>">
                <?php if ($messageTrend === null): ?>
                    暂无历史对比数据
                <?php else: ?>
                    <span class="metric-card__trend-arrow"><?= $messageTrend >= 0 ? '↑' : '↓' ?></span>
                    较前 7 日 <?= abs($messageTrend) ?>%
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="dashboard-panel dashboard-panel--lg">
            <div class="dashboard-panel__header">
                <div class="dashboard-panel__title">战役与英雄分布概览</div>
                <div class="dashboard-panel__subtitle">按年份统计战役数量，并对比各战役下英雄数量</div>
            </div>
            <div style="height:280px; max-width:100%; overflow:hidden;">
                <canvas id="campaignHeroChart" height="240"></canvas>
            </div>
        </div>

        <div class="dashboard-panel dashboard-panel--sm">
            <div class="dashboard-panel__header">
                <div class="dashboard-panel__title">资源类型占比</div>
                <div class="dashboard-panel__subtitle">文物、文献、英雄、战役等资源结构</div>
            </div>
            <div style="height:240px; max-width:100%; overflow:hidden;">
                <canvas id="resourcePieChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="dashboard-panel dashboard-panel--lg">
            <div class="dashboard-panel__header">
                <div class="dashboard-panel__title">近 7 日后台访问量</div>
                <div class="dashboard-panel__subtitle">按日统计后台页面访问次数</div>
            </div>
            <div style="height:240px; max-width:100%; overflow:hidden;">
                <canvas id="visitLineChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <div class="dashboard-row dashboard-row--bottom">
        <div class="dashboard-panel dashboard-panel--list">
            <div class="dashboard-panel__header">
                <div class="dashboard-panel__title">最新留言</div>
                <div class="dashboard-panel__subtitle">来自前台纪念页面的实时反馈</div>
            </div>
            <div id="dashboard-latest-messages" class="dashboard-list-placeholder">
                请在后续迭代中接入最新留言列表。
            </div>
        </div>
        <div class="dashboard-panel dashboard-panel--list">
            <div class="dashboard-panel__header">
                <div class="dashboard-panel__title">最新史料 / 文物录入</div>
                <div class="dashboard-panel__subtitle">关注最近补充的关键资料</div>
            </div>
            <div id="dashboard-latest-resources" class="dashboard-list-placeholder">
                请在后续迭代中接入最近上传的史料与文物数据。
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        var ctx = document.getElementById('campaignHeroChart');
        if (!ctx) return;

        var yearLabels = <?= Json::encode($campaignYearLabels) ?>;
        var yearCounts = <?= Json::encode($campaignYearCounts) ?>;
        var heroLabels = <?= Json::encode($heroCampaignLabels) ?>;
        var heroCounts = <?= Json::encode($heroCampaignCounts) ?>;

        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: yearLabels,
                datasets: [{
                    label: '战役数量',
                    data: yearCounts,
                    backgroundColor: 'rgba(248, 113, 113, 0.6)',
                    borderColor: 'rgba(248, 113, 113, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: { beginAtZero: true, precision: 0 },
                        gridLines: { color: 'rgba(148, 163, 184, 0.2)' }
                    }],
                    xAxes: [{
                        gridLines: { color: 'rgba(148, 163, 184, 0.2)' },
                        ticks: { maxRotation: 0, autoSkip: true }
                    }]
                }
            }
        });

        var pieCtx = document.getElementById('resourcePieChart');
        if (!pieCtx) return;

        new Chart(pieCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['文物', '史料文献', '英雄', '战役'],
                datasets: [{
                    data: [
                        <?= (int)$totals['relics'] ?>,
                        <?= (int)$totals['docs'] ?>,
                        <?= (int)$totals['heroes'] ?>,
                        <?= (int)$totals['campaigns'] ?>
                    ],
                    backgroundColor: [
                        'rgba(248, 113, 113, 0.9)',
                        'rgba(251, 191, 36, 0.9)',
                        'rgba(56, 189, 248, 0.9)',
                        'rgba(129, 140, 248, 0.9)'
                    ],
                    borderColor: 'rgba(15, 23, 42, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: { fontColor: '#d1d5db' }
                },
                cutoutPercentage: 65
            }
        });
    })();
</script>

<script>
    (function() {
        var vctx = document.getElementById('visitLineChart');
        if (!vctx) return;
        var labels = <?= Json::encode($visitLabels) ?>;
        var counts = <?= Json::encode($visitCounts) ?>;
        new Chart(vctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: '访问量',
                    data: counts,
                    borderColor: 'rgba(56, 189, 248, 1)',
                    backgroundColor: 'rgba(56, 189, 248, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, precision: 0 } }],
                    xAxes: [{ gridLines: { color: 'rgba(148, 163, 184, 0.2)' } }]
                }
            }
        });
    })();
</script>
