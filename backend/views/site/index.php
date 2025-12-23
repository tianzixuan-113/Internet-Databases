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
            <div class="metric-card__value js-counter" data-target="<?= (int)$totals['relics'] ?>">0</div>
            <div class="metric-card__meta">涵盖重要抗战文物与藏品</div>
        </div>
        <div class="metric-card">
            <div class="metric-card__label">史料文献总数</div>
            <div class="metric-card__value js-counter" data-target="<?= (int)$totals['docs'] ?>">0</div>
            <div class="metric-card__meta">战报、电报、回忆录等文献</div>
        </div>
        <div class="metric-card">
            <div class="metric-card__label">英雄人物数量</div>
            <div class="metric-card__value js-counter" data-target="<?= (int)$totals['heroes'] ?>">0</div>
            <div class="metric-card__meta">关联典型战役与部队信息</div>
        </div>
        <div class="metric-card">
            <div class="metric-card__label">战役档案数量</div>
            <div class="metric-card__value js-counter" data-target="<?= (int)$totals['campaigns'] ?>">0</div>
            <div class="metric-card__meta">覆盖重要战役节点</div>
        </div>
        <div class="metric-card">
            <div class="metric-card__label">近 7 日新增留言</div>
            <div class="metric-card__value js-counter" data-target="<?= (int)$messagesLast7 ?>">0</div>
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

    <div class="dashboard-row">
        <div class="dashboard-panel dashboard-panel--lg">
            <div class="dashboard-panel__header" style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                <div>
                    <div class="dashboard-panel__title">Top 路由</div>
                    <div class="dashboard-panel__subtitle">前台访问最多的页面（动态刷新）</div>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    <label for="daysSelAdmin" style="color:#94a3b8;">天数</label>
                    <select id="daysSelAdmin" class="form-control" style="min-width:100px;">
                        <option value="7" selected>近 7 天</option>
                        <option value="14">近 14 天</option>
                        <option value="30">近 30 天</option>
                    </select>
                    <label style="color:#94a3b8;">自动刷新</label>
                    <input type="checkbox" id="autoRefreshAdmin" checked>
                </div>
            </div>
            <div style="height:280px; max-width:100%; overflow:hidden;">
                <canvas id="topRoutesChartAdmin" height="240"></canvas>
            </div>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="dashboard-panel dashboard-panel--sm">
            <div class="dashboard-panel__header">
                <div class="dashboard-panel__title">图片域名分布</div>
                <div class="dashboard-panel__subtitle">图片链接所指向域名的占比（动态刷新）</div>
            </div>
            <div style="height:240px; max-width:100%; overflow:hidden;">
                <canvas id="imageHostChartAdmin" height="220"></canvas>
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
// 简易数字递增动画 + Chart 全局动画
(function(){
    function animateCounter(el, to){
        var start = 0, dur = 900, t0 = performance.now();
        function step(t){
            var p = Math.min((t - t0)/dur, 1);
            el.textContent = Math.floor(start + (to - start) * (1 - Math.pow(1-p, 3)));
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }
    document.querySelectorAll('.js-counter').forEach(function(el){
        var to = parseInt(el.getAttribute('data-target')||'0',10);
        animateCounter(el, to);
    });
    if (window.Chart && Chart.defaults && Chart.defaults.global && Chart.defaults.global.animation) {
        Chart.defaults.global.animation.duration = 900;
        Chart.defaults.global.animation.easing = 'easeOutQuart';
    }
})();
</script>
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
        var visitChart = new Chart(vctx.getContext('2d'), {
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

        // Admin dynamic charts: Top Routes + Image Host Dist
        var topRoutesCtx = document.getElementById('topRoutesChartAdmin')?.getContext('2d');
        var imageHostCtx = document.getElementById('imageHostChartAdmin')?.getContext('2d');
        var topRoutesChart = null;
        var imageHostChart = null;
        var autoChk = document.getElementById('autoRefreshAdmin');
        var daysSel = document.getElementById('daysSelAdmin');
        var timer = null;

        function ensureCharts(){
            if (topRoutesCtx && !topRoutesChart) {
                topRoutesChart = new Chart(topRoutesCtx, {
                    type: 'bar',
                    data: { labels: [], datasets: [{
                        label: '访问量', data: [],
                        backgroundColor: 'rgba(34,197,94,0.25)',
                        borderColor: 'rgba(34,197,94,0.9)', borderWidth: 1
                    }]},
                    options: { indexAxis: 'y', responsive:true, maintainAspectRatio:false,
                        scales:{ x:{ beginAtZero:true, ticks:{ precision:0 } }, y:{} },
                        animation:{ duration: 800 } }
                });
            }
            if (imageHostCtx && !imageHostChart) {
                imageHostChart = new Chart(imageHostCtx, {
                    type: 'doughnut',
                    data: { labels: [], datasets: [{ data: [], backgroundColor: ['#ef4444','#f59e0b','#10b981','#3b82f6','#8b5cf6','#ec4899','#22c55e','#06b6d4','#94a3b8'], borderWidth:1 }]},
                    options: { responsive:true, maintainAspectRatio:false, cutout: '60%' }
                });
            }
        }

        async function refreshData(){
            try {
                // visits summary (days selector)
                var days = parseInt(daysSel?.value||'7',10);
                var vres = await fetch('index.php?r=api/visits-summary&days=' + days, {cache:'no-cache'});
                var vjson = await vres.json();
                if (vjson && vjson.ok && Array.isArray(vjson.data)){
                    visitChart.data.labels = vjson.data.map(function(x){return x.day;});
                    visitChart.data.datasets[0].data = vjson.data.map(function(x){return parseInt(x.count,10)||0;});
                    visitChart.update();
                }

                ensureCharts();

                // top routes
                if (topRoutesChart){
                    var rres = await fetch('index.php?r=api/top-routes&limit=8', {cache:'no-cache'});
                    var rjson = await rres.json();
                    if (rjson && rjson.ok && Array.isArray(rjson.data)){
                        topRoutesChart.data.labels = rjson.data.map(function(x){return x.route;});
                        topRoutesChart.data.datasets[0].data = rjson.data.map(function(x){return parseInt(x.count,10)||0;});
                        topRoutesChart.update();
                    }
                }

                // image host dist
                if (imageHostChart){
                    var hres = await fetch('index.php?r=api/image-host-dist&top=8', {cache:'no-cache'});
                    var hjson = await hres.json();
                    if (hjson && hjson.ok && Array.isArray(hjson.data)){
                        imageHostChart.data.labels = hjson.data.map(function(x){return x.host;});
                        imageHostChart.data.datasets[0].data = hjson.data.map(function(x){return parseInt(x.count,10)||0;});
                        imageHostChart.update();
                    }
                }
            } catch(e) { /* ignore */ }
        }

        function startTimer(){ if (timer) clearInterval(timer); timer = setInterval(function(){ if (!autoChk || autoChk.checked) refreshData(); }, 10000); }
        if (daysSel) daysSel.addEventListener('change', refreshData);
        if (autoChk) autoChk.addEventListener('change', function(){ if (autoChk.checked) refreshData(); });
        // initial load
        refreshData(); startTimer();
    })();
</script>
