<?php
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $totals array */
/* @var $campaignByYear array */
/* @var $visitTrend array */
/* @var $topRoutes array */
/* @var $imageHostDist array */

$this->title = '数据可视化';
$this->params['breadcrumbs'][] = $this->title;

$cyLabels = array_column($campaignByYear, 'year');
$cyCounts = array_column($campaignByYear, 'count');
$visitLabels = array_column($visitTrend, 'day');
$visitCounts = array_column($visitTrend, 'count');
$routeLabels = array_column($topRoutes, 'route');
$routeCounts = array_column($topRoutes, 'count');
$hostLabels = array_column($imageHostDist, 'host');
$hostCounts = array_column($imageHostDist, 'count');
?>

<style>
.stats-hero { background: linear-gradient(135deg,#f5f7fa,#e4edf5); padding:40px 0; text-align:center; margin-bottom:24px; }
.counter-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:16px; margin-bottom:24px; }
.counter { background:#fff; border-radius:12px; box-shadow:0 6px 16px rgba(0,0,0,.06); padding:18px; }
.counter .label{ color:#6b7280; font-size:13px; }
.counter .value{ font-size:28px; font-weight:700; color:#111827; }
.panel { background:#fff; border-radius:12px; box-shadow:0 6px 16px rgba(0,0,0,.06); padding:16px; margin-bottom:24px; }
.panel h3 { margin:0 0 8px; font-size:16px; color:#111827; }
.panel p.sub { margin:0 0 12px; color:#6b7280; font-size:13px; }
</style>

<div class="stats-hero">
  <div class="container">
    <h1 style="margin:0; font-weight:700;">数据可视化</h1>
    <p style="margin-top:8px; color:#6b7280;">动态展示战役分布与近7日访问趋势</p>
  </div>
</div>

<div class="container">
  <div class="counter-grid">
    <div class="counter"><div class="label">战役</div><div class="value" data-counter="<?= (int)$totals['campaigns'] ?>">0</div></div>
    <div class="counter"><div class="label">英雄</div><div class="value" data-counter="<?= (int)$totals['heroes'] ?>">0</div></div>
    <div class="counter"><div class="label">史料文献</div><div class="value" data-counter="<?= (int)$totals['docs'] ?>">0</div></div>
    <div class="counter"><div class="label">文物</div><div class="value" data-counter="<?= (int)$totals['relics'] ?>">0</div></div>
    <div class="counter"><div class="label">图片</div><div class="value" data-counter="<?= (int)$totals['images'] ?>">0</div></div>
  </div>

  <div class="panel">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:8px; flex-wrap:wrap;">
      <div>
        <h3 style="margin-bottom:2px;">战役年份分布</h3>
      <div class="panel">
        <h3 style="margin-bottom:2px;">Top 路由</h3>
        <p class="sub" style="margin:0;">前台访问最多的页面（动态刷新）</p>
        <div style="height:260px"><canvas id="topRoutesChart" height="240"></canvas></div>
      </div>

      <div class="panel">
        <h3 style="margin-bottom:2px;">图片域名分布</h3>
        <p class="sub" style="margin:0;">图片链接所指向域名的占比（动态刷新）</p>
        <div style="height:260px"><canvas id="imageHostChart" height="240"></canvas></div>
      </div>

        <p class="sub" style="margin:0;">按年份统计战役数量（自动刷新）</p>
      </div>
      <div style="display:flex; align-items:center; gap:8px;">
        <label style="color:#6b7280; font-size:13px;">自动刷新</label>
        <input type="checkbox" id="autoRefresh" checked>
      </div>
    </div>
    <div style="height:260px"><canvas id="campaignYearChart" height="240"></canvas></div>
  </div>

  <div class="panel">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:8px; flex-wrap:wrap;">
      <div>
        <h3 style="margin-bottom:2px;">访问趋势</h3>
        <p class="sub" style="margin:0;">来自前台共享缓存的访问计数</p>
      </div>
      <div style="display:flex; align-items:center; gap:8px;">
        <label for="daysSel" style="color:#6b7280; font-size:13px;">天数</label>
        <select id="daysSel" class="form-control" style="min-width:100px;">
          <option value="7" selected>近 7 天</option>
          <option value="14">近 14 天</option>
          <option value="30">近 30 天</option>
        </select>
      </div>
    </div>
    <div style="height:260px"><canvas id="visitTrendChart" height="240"></canvas></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
  // 简易数字递增动画
  function animateCounter(el, to){
    var start = 0, dur = 800, t0 = performance.now();
    function step(t){
      var p = Math.min((t - t0)/dur, 1);
      el.textContent = Math.floor(start + (to - start) * (1 - Math.pow(1-p, 3)));
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  function animateCounterTo(el, to){
    var current = parseInt(el.textContent||'0',10) || 0;
    var start = current, dur = 600, t0 = performance.now();
    function step(t){
      var p = Math.min((t - t0)/dur, 1);
      el.textContent = Math.floor(start + (to - start) * (1 - Math.pow(1-p, 3)));
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }
  // 首次进场动画
  document.querySelectorAll('.counter .value').forEach(function(v){
    var to = parseInt(v.getAttribute('data-counter')||'0',10); animateCounter(v, to);
  });

  // Chart.js 全局动画设置（兼容 v3/v4，无 global）
  if (window.Chart && Chart.defaults) {
    if (Chart.defaults.animation) {
      Chart.defaults.animation.duration = 900;
      Chart.defaults.animation.easing = 'easeOutQuart';
    }
  }

  var cyLabels = <?= Json::encode($cyLabels) ?>;
  var cyCounts = <?= Json::encode($cyCounts) ?>;
  var c1 = document.getElementById('campaignYearChart').getContext('2d');
  var cyChart = new Chart(c1, {
    type: 'bar',
    data: { labels: cyLabels, datasets: [{
      label: '战役数量', data: cyCounts,
      backgroundColor: 'rgba(139,0,0,0.25)', borderColor: 'rgba(139,0,0,0.9)', borderWidth: 1
    }]},
    options: {
      responsive:true, maintainAspectRatio:false,
      scales:{ y:{ beginAtZero:true, ticks:{ precision:0 } }, x:{} },
      animation:{
        onComplete: function(){ /* 可在此添加数字标注等 */ }
      }
    }
  });

  var vLabels = <?= Json::encode($visitLabels) ?>;
  var vCounts = <?= Json::encode($visitCounts) ?>;
  var c2 = document.getElementById('visitTrendChart').getContext('2d');
  var vChart = new Chart(c2, {
    type: 'line',
    data: { labels: vLabels, datasets: [{
      label: '访问量', data: vCounts,
      borderColor: 'rgba(30,144,255,1)', backgroundColor: 'rgba(30,144,255,0.2)', fill:true,
      pointRadius: 3, tension: 0.25
    }]},
    options: {
      responsive:true, maintainAspectRatio:false,
      scales:{ y:{ beginAtZero:true, ticks:{ precision:0 } }, x:{} },
      elements:{ point:{ hoverRadius:5 }},
      animation:{ duration: 1000 }
    }
  });

  // Top 路由（水平条形图）
  var rLabels = <?= Json::encode($routeLabels) ?>;
  var rCounts = <?= Json::encode($routeCounts) ?>;
  var c3 = document.getElementById('topRoutesChart').getContext('2d');
  var rChart = new Chart(c3, {
    type: 'bar',
    data: { labels: rLabels, datasets: [{
      label: '访问量', data: rCounts,
      backgroundColor: 'rgba(34,197,94,0.25)', borderColor: 'rgba(34,197,94,0.9)', borderWidth: 1
    }]},
    options: {
      indexAxis: 'y',
      responsive:true, maintainAspectRatio:false,
      scales:{ x:{ beginAtZero:true, ticks:{ precision:0 } }, y:{} },
      animation:{ duration: 800 }
    }
  });

  // 图片域名分布（环形图）
  var hLabels = <?= Json::encode($hostLabels) ?>;
  var hCounts = <?= Json::encode($hostCounts) ?>;
  var c4 = document.getElementById('imageHostChart').getContext('2d');
  var hChart = new Chart(c4, {
    type: 'doughnut',
    data: { labels: hLabels, datasets: [{
      data: hCounts,
      backgroundColor: ['#ef4444','#f59e0b','#10b981','#3b82f6','#8b5cf6','#ec4899','#22c55e','#06b6d4','#94a3b8'],
      borderWidth: 1
    }]},
    options: { responsive:true, maintainAspectRatio:false, cutout: '60%' }
  });

  // 动态拉取后端最新数据（同页控制器提供 JSON），并更新图表/计数
  var daysSel = document.getElementById('daysSel');
  var autoChk = document.getElementById('autoRefresh');
  var refreshTimer = null;

  async function fetchAndUpdate(){
    var days = parseInt(daysSel.value||'7',10);
    try{
      var resp = await fetch('index.php?r=stats/data&days=' + days, {cache:'no-cache'});
      var json = await resp.json();
      if (!json || json.ok !== true) return;
      var d = json.data || {};
      // 更新计数器
      var totals = d.totals || {};
      var map = {
        campaigns: '战役', heroes: '英雄', docs: '史料文献', relics: '文物', images: '图片'
      };
      document.querySelectorAll('.counter .value').forEach(function(v){
        var label = v.parentElement.querySelector('.label').textContent.trim();
        var key = Object.keys(map).find(function(k){return map[k]===label;});
        if (key && typeof totals[key] !== 'undefined'){
          v.setAttribute('data-counter', totals[key]);
          animateCounterTo(v, parseInt(totals[key],10));
        }
      });
      // 更新战役年份分布
      if (d.campaignByYear && Array.isArray(d.campaignByYear)){
        cyChart.data.labels = d.campaignByYear.map(function(x){return x.year;});
        cyChart.data.datasets[0].data = d.campaignByYear.map(function(x){return parseInt(x.count,10)||0;});
        cyChart.update();
      }
      // 更新访问趋势
      if (d.visitTrend && Array.isArray(d.visitTrend)){
        vChart.data.labels = d.visitTrend.map(function(x){return x.day;});
        vChart.data.datasets[0].data = d.visitTrend.map(function(x){return parseInt(x.count,10)||0;});
        vChart.update();
      }
      // 更新 Top 路由
      if (d.topRoutes && Array.isArray(d.topRoutes)){
        rChart.data.labels = d.topRoutes.map(function(x){return x.route;});
        rChart.data.datasets[0].data = d.topRoutes.map(function(x){return parseInt(x.count,10)||0;});
        rChart.update();
      }
      // 更新 图片域名分布
      if (d.imageHostDist && Array.isArray(d.imageHostDist)){
        hChart.data.labels = d.imageHostDist.map(function(x){return x.host;});
        hChart.data.datasets[0].data = d.imageHostDist.map(function(x){return parseInt(x.count,10)||0;});
        hChart.update();
      }
    }catch(e){ /* 忽略拉取错误，等待下次 */ }
  }

  function startAuto(){
    if (refreshTimer) clearInterval(refreshTimer);
    refreshTimer = setInterval(function(){ if (autoChk.checked) fetchAndUpdate(); }, 10000);
  }
  daysSel.addEventListener('change', fetchAndUpdate);
  autoChk.addEventListener('change', function(){ if (autoChk.checked) fetchAndUpdate(); });
  // 首次触发一次，然后启动定时刷新
  fetchAndUpdate();
  startAuto();
})();
</script>
