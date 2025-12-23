<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $docs common\models\HistoricalDoc[] */
/* @var $campaigns common\models\WarCampaign[] */

$this->title = '史料文献';
$this->params['breadcrumbs'][] = $this->title;

// 分组：按 doc_type → 年份（依据关联战役 start_time 推导）
$grouped = [];
foreach ($docs as $d) {
    $type = trim((string)$d->doc_type) ?: '其它';
    $year = '未知年份';
    if (!empty($d->related_campaign_id) && isset($campaigns[$d->related_campaign_id])) {
        $st = $campaigns[$d->related_campaign_id]->start_time;
        if (!empty($st)) {
            $y = (int)date('Y', strtotime($st));
            if ($y > 0) $year = (string)$y;
        }
    }
    $grouped[$type][$year][] = $d;
}
ksort($grouped);
// 按年份排序（数字在前，未知在后）
foreach ($grouped as $type => $years) {
    $numeric = []; $unknown = [];
    foreach ($years as $y => $rows) {
        if ($y === '未知年份') $unknown[$y] = $rows; else $numeric[$y] = $rows;
    }
    ksort($numeric, SORT_NATURAL);
    $grouped[$type] = $numeric + $unknown; // 先数字后未知
}
?>

<style>
.doc-toolbar { display:flex; gap:10px; align-items:center; margin:10px 0 14px 0; }
.doc-search { flex:1; }
.doc-tabs { position:sticky; top:10px; z-index:5; display:flex; gap:8px; flex-wrap:wrap; padding:8px 0; background:linear-gradient(180deg, rgba(13,17,23,.95), rgba(13,17,23,.8)); backdrop-filter: blur(4px); }
.doc-tab { padding:6px 12px; border-radius:999px; border:1px solid #1f2937; color:#cbd5e1; background:#0b1220; cursor:pointer; user-select:none; }
.doc-tab.active { background:#111827; border-color:#334155; color:#e6edf3; }
.doc-section { margin-bottom:22px; }
.doc-section__title { display:flex; align-items:center; gap:8px; margin:12px 0 8px 0; }
.badge-type { display:inline-flex; align-items:center; height:22px; padding:0 8px; font-size:12px; border-radius:999px; background:#111827; color:#cbd5e1; border:1px solid #1f2937; }
.timeline { position:relative; }
.timeline::before { content:''; position:absolute; left:14px; top:0; bottom:0; width:2px; background:#1f2937; }
.t-item { position:relative; padding-left:40px; margin:12px 0; }
.t-item::before { content:''; position:absolute; left:9px; top:8px; width:10px; height:10px; border-radius:50%; background:#1f6feb; box-shadow:0 0 0 4px rgba(31,111,235,.15); }
.card { border-radius:12px; background:#0d1117; border:1px solid #1f2937; box-shadow: 0 8px 18px rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.04); padding:12px 14px; transition: border-color .2s ease, transform .15s ease; }
.card:hover { border-color:#334155; transform: translateY(-2px); }
.card__title { font-weight:700; color:#e6edf3; }
.card__meta { color:#94a3b8; font-size:12px; margin-top:4px; }
.card__summary { color:#cbd5e1; font-size:13px; margin-top:6px; }
.card__ops { margin-top:8px; display:flex; gap:8px; }
.btn-xs-ghost { padding:4px 8px; border-radius:6px; font-size:12px; background:#0b1220; color:#cbd5e1; border:1px solid #1f2937; }
.btn-xs-ghost:hover { border-color:#334155; color:#e6edf3; }
.hidden { display:none !important; }
</style>

<div class="doc-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($docs)): ?>
        <div class="doc-toolbar">
            <input id="docFilter" class="form-control doc-search" type="text" placeholder="搜索文献标题 / 类型 / 摘要">
            <span class="text-muted">共 <?= count($docs) ?> 篇</span>
        </div>

        <div class="doc-tabs" id="docTabs">
            <div class="doc-tab active" data-type="">全部</div>
            <?php foreach (array_keys($grouped) as $type): ?>
                <div class="doc-tab" data-type="<?= Html::encode(strtolower($type)) ?>"><?= Html::encode($type) ?></div>
            <?php endforeach; ?>
        </div>

        <?php foreach ($grouped as $type => $years): ?>
            <div class="doc-section doc-type-section" data-type="<?= Html::encode(strtolower($type)) ?>">
                <div class="doc-section__title">
                    <span class="badge-type">类型：<?= Html::encode($type) ?></span>
                    <?php $total=0; foreach($years as $_y=>$_r){ $total+=count($_r);} ?>
                    <span class="text-muted">（<?= $total ?>）</span>
                </div>
                <?php foreach ($years as $year => $rows): ?>
                    <div class="timeline" data-section="<?= Html::encode(strtolower($type)) ?>">
                        <div class="t-item" style="margin:8px 0 2px 0; padding-left:0;">
                            <div class="card" style="background:#0b1220; color:#94a3b8; border-style:dashed;">
                                年份：<?= Html::encode($year) ?>
                            </div>
                        </div>
                        <?php foreach ($rows as $d): $summary = trim((string)$d->doc_summary); $url = \yii\helpers\Url::to(['doc/view','id'=>$d->doc_id], true); ?>
                            <div class="t-item" data-text="<?= Html::encode(strtolower(($d->doc_name.' '.$type.' '.$summary))) ?>">
                                <div class="card">
                                    <div class="card__title">
                                        <a href="<?= Html::encode($url) ?>" id="doc-<?= Html::encode($d->doc_id) ?>"><?= Html::encode($d->doc_name) ?></a>
                                    </div>
                                    <div class="card__meta">#<?= Html::encode($d->doc_id) ?> · 类型：<?= Html::encode($type) ?> · 年份：<?= Html::encode($year) ?></div>
                                    <?php if ($summary !== ''): ?>
                                        <div class="card__summary"><?= Html::encode(mb_substr($summary, 0, 160)) ?><?= mb_strlen($summary) > 160 ? '…' : '' ?></div>
                                    <?php endif; ?>
                                    <div class="card__ops">
                                        <button class="btn-xs-ghost js-fav" data-id="<?= Html::encode($d->doc_id) ?>">☆ 收藏</button>
                                        <button class="btn-xs-ghost js-copy" data-url="<?= Html::encode($url) ?>">⧉ 复制链接</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <script>
        (function(){
            var input = document.getElementById('docFilter');
            var tabs = document.getElementById('docTabs');
            function apply(){
                var v = (input && input.value || '').toLowerCase();
                var active = document.querySelector('.doc-tab.active');
                var type = active ? (active.getAttribute('data-type') || '') : '';
                document.querySelectorAll('.doc-type-section').forEach(function(typeSec){
                    var secType = typeSec.getAttribute('data-type') || '';
                    var matchType = !type || type === secType;
                    typeSec.style.display = matchType ? '' : 'none';
                    if (!matchType) return;
                    typeSec.querySelectorAll('.timeline .t-item').forEach(function(el){
                        var t = el.getAttribute('data-text') || '';
                        // 年份标题行不带 data-text，直接跳过
                        if (!t) return;
                        el.classList.toggle('hidden', v && t.indexOf(v) === -1);
                    });
                });
            }
            if (input) input.addEventListener('input', apply);
            if (tabs) tabs.addEventListener('click', function(e){
                var tab = e.target.closest('.doc-tab');
                if (!tab) return;
                document.querySelectorAll('.doc-tab').forEach(function(x){ x.classList.remove('active'); });
                tab.classList.add('active');
                apply();
            });
            // 收藏与复制
            function getFav(){ try{ return JSON.parse(localStorage.getItem('favDocs')||'[]'); }catch(e){ return []; } }
            function setFav(list){ localStorage.setItem('favDocs', JSON.stringify(list)); }
            function isFav(id){ var l=getFav(); return l.indexOf(id)!==-1; }
            function toggleFav(id, el){ var l=getFav(); var i=l.indexOf(id); if(i===-1){l.push(id);} else {l.splice(i,1);} setFav(l); renderFav(el,id); }
            function renderFav(el,id){ el.textContent = (isFav(id)?'★ 已收藏':'☆ 收藏'); }
            document.addEventListener('click', function(e){
                var f = e.target.closest('.js-fav'); if (f){ var id = parseInt(f.getAttribute('data-id'),10); if(!isNaN(id)) toggleFav(id, f); }
                var c = e.target.closest('.js-copy'); if (c){ var url = c.getAttribute('data-url'); if (navigator.clipboard && navigator.clipboard.writeText){ navigator.clipboard.writeText(url); c.textContent='✔ 已复制'; setTimeout(function(){ c.textContent='⧉ 复制链接';}, 1200);} else { var ta = document.createElement('textarea'); ta.value=url; document.body.appendChild(ta); ta.select(); try{ document.execCommand('copy'); }catch(e){} document.body.removeChild(ta); c.textContent='✔ 已复制'; setTimeout(function(){ c.textContent='⧉ 复制链接';}, 1200);} }
            });
            // 初始渲染收藏状态
            document.querySelectorAll('.js-fav').forEach(function(el){ var id=parseInt(el.getAttribute('data-id'),10); if(!isNaN(id)) renderFav(el,id); });
            apply();
        })();
        </script>
    <?php else: ?>
        <p>暂无文献数据。</p>
    <?php endif; ?>
</div>