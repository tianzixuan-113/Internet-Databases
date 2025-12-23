<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $heroes common\models\HeroInfo[] */
/* @var $campaigns array<int,string> */
/* @var $armies string[] */
/* @var $places string[] */

$this->title = '抗战英雄';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.hero-board__toolbar { display:flex; gap:10px; align-items:center; margin:10px 0 14px 0; }
.hero-search { flex:1; }
.hero-campaign { width:200px; }
.hero-army, .hero-place { width:180px; }
.hero-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap:14px; }
.hero-card { border-radius:14px; overflow:hidden; background:#0d1117; border:1px solid #1f2937; box-shadow:0 6px 18px rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.03); transition:transform .15s ease, box-shadow .2s ease, border-color .2s ease; }
.hero-card:hover { transform: translateY(-2px); box-shadow:0 12px 28px rgba(0,0,0,.35); border-color:#334155; }
.hero-card__head { background: radial-gradient(120% 120% at 0% 0%, #1f6feb 0%, rgba(31,111,235,0.15) 55%, rgba(31,111,235,0.06) 100%); padding:14px 16px; display:flex; align-items:center; gap:12px; color:#e6edf3; }
.hero-avatar { width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg, rgba(255,255,255,.15), rgba(255,255,255,.02)); display:flex; align-items:center; justify-content:center; font-weight:700; color:#0d1117; }
.hero-card__title { font-weight:700; font-size:16px; letter-spacing:.3px; }
.hero-card__meta { color:#94a3b8; font-size:12px; margin-top:2px; }
.chip { display:inline-flex; align-items:center; height:22px; padding:0 8px; font-size:12px; border-radius:999px; background:#111827; color:#cbd5e1; border:1px solid #1f2937; }
.chip + .chip { margin-left:6px; }
.hero-card__body { padding:12px 14px; display:flex; justify-content:space-between; align-items:center; }
.hero-card__actions a { margin-left:8px; }
.hero-card { position:relative; }
.hero-card__hover { position:absolute; inset:0; background:rgba(13,17,23,.96); color:#cbd5e1; padding:12px 14px; opacity:0; pointer-events:none; transition:opacity .15s ease; font-size:13px; }
.hero-card:hover .hero-card__hover { opacity:1; }
.muted { color:#94a3b8; }
.hidden { display:none !important; }
</style>

<div class="hero-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($heroes)): ?>
        <div class="hero-board__toolbar">
            <input id="heroFilter" class="form-control hero-search" type="text" placeholder="搜索英雄姓名 / 籍贯 / 部队 / 战役">
            <select id="heroCampaign" class="form-control hero-campaign">
                <option value="">全部战役</option>
                <option value="__none__">未指定战役</option>
                <?php if (!empty($campaigns)) foreach ($campaigns as $cid => $cname): ?>
                    <option value="<?= Html::encode($cid) ?>"><?= Html::encode($cname) ?></option>
                <?php endforeach; ?>
            </select>
            <select id="heroArmy" class="form-control hero-army">
                <option value="">全部部队</option>
                <?php if (!empty($armies)) foreach ($armies as $a): ?>
                    <option value="<?= Html::encode(strtolower($a)) ?>"><?= Html::encode($a) ?></option>
                <?php endforeach; ?>
            </select>
            <select id="heroPlace" class="form-control hero-place">
                <option value="">全部籍贯</option>
                <?php if (!empty($places)) foreach ($places as $p): ?>
                    <option value="<?= Html::encode(strtolower($p)) ?>"><?= Html::encode($p) ?></option>
                <?php endforeach; ?>
            </select>
            <span class="muted">共 <?= count($heroes) ?> 位</span>
        </div>

        <div id="heroGrid" class="hero-grid">
            <?php foreach ($heroes as $hero):
                $name = (string)$hero->hero_name;
                $avatar = mb_substr($name, 0, 1);
                $campaign = $hero->campaign ? $hero->campaign->campaign_name : '未指定战役';
                $campaignId = $hero->campaign ? $hero->campaign->campaign_id : '__none__';
            ?>
            <div class="hero-card" data-campaign="<?= Html::encode($campaignId) ?>" data-army="<?= Html::encode(strtolower($hero->army ?: '')) ?>" data-place="<?= Html::encode(strtolower($hero->native_place ?: '')) ?>" data-text="<?= Html::encode(strtolower($name.' '.($hero->native_place ?: '').' '.($hero->army ?: '').' '.($campaign ?: ''))) ?>">
                <div class="hero-card__head">
                    <div class="hero-avatar"><span><?= Html::encode($avatar) ?></span></div>
                    <div>
                        <div class="hero-card__title"><?= Html::encode($name) ?></div>
                        <div class="hero-card__meta">#<?= Html::encode($hero->hero_id) ?></div>
                    </div>
                </div>
                <div class="hero-card__body">
                    <div>
                        <span class="chip" title="籍贯"><?= Html::encode($hero->native_place ?: '籍贯不详') ?></span>
                        <span class="chip" title="部队"><?= Html::encode($hero->army ?: '部队未知') ?></span>
                        <span class="chip" title="战役"><?= Html::encode($campaign) ?></span>
                    </div>
                    <div class="hero-card__actions">
                        <?= Html::a('查看', ['hero/view', 'id' => $hero->hero_id], ['class' => 'btn btn-xs btn-primary']) ?>
                    </div>
                </div>
                <?php if (trim((string)$hero->deed) !== ''): ?>
                <div class="hero-card__hover">
                    <div style="font-weight:700; color:#e6edf3; margin-bottom:6px;">事迹摘要</div>
                    <div><?= Html::encode(mb_substr((string)$hero->deed, 0, 220)) ?><?= mb_strlen((string)$hero->deed) > 220 ? '…' : '' ?></div>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center; margin:14px 0;">
            <button id="heroLoadMore" class="btn btn-default">加载更多</button>
            <span id="heroCount" class="muted" style="margin-left:8px;"></span>
        </div>

        <script>
        (function(){
            var input = document.getElementById('heroFilter');
            var sel = document.getElementById('heroCampaign');
            var selArmy = document.getElementById('heroArmy');
            var selPlace = document.getElementById('heroPlace');
            var grid = document.getElementById('heroGrid');
            var moreBtn = document.getElementById('heroLoadMore');
            var countEl = document.getElementById('heroCount');
            if(!input||!grid) return;
            var page = 1, step = 24;
            function apply(){
                var v = (input.value || '').toLowerCase();
                var c = sel ? (sel.value || '') : '';
                var a = selArmy ? (selArmy.value || '') : '';
                var p = selPlace ? (selPlace.value || '') : '';
                Array.prototype.forEach.call(grid.children, function(card){
                    var t = card.getAttribute('data-text') || '';
                    var cc = card.getAttribute('data-campaign') || '';
                    var ca = card.getAttribute('data-army') || '';
                    var cp = card.getAttribute('data-place') || '';
                    var hitText = !v || t.indexOf(v) !== -1;
                    var hitCamp = !c || cc === c;
                    var hitArmy = !a || ca === a;
                    var hitPlace = !p || cp === p;
                    card.classList.toggle('hidden', !(hitText && hitCamp && hitArmy && hitPlace));
                });
                // 重置分页
                page = 1;
                applyPage();
            }
            function applyPage(){
                var visible = Array.prototype.filter.call(grid.children, function(card){ return !card.classList.contains('hidden'); });
                var total = visible.length;
                var show = page * step;
                visible.forEach(function(card, idx){ card.style.display = (idx < show) ? '' : 'none'; });
                if (moreBtn) moreBtn.style.display = (show < total) ? '' : 'none';
                if (countEl) countEl.textContent = total ? ('已显示 ' + Math.min(show, total) + '/' + total) : '无匹配结果';
            }
            input.addEventListener('input', apply);
            if (sel) sel.addEventListener('change', apply);
            if (selArmy) selArmy.addEventListener('change', apply);
            if (selPlace) selPlace.addEventListener('change', apply);
            if (moreBtn) moreBtn.addEventListener('click', function(){ page++; applyPage(); });
            apply();
        })();
        </script>
    <?php else: ?>
        <p>暂无英雄数据。</p>
    <?php endif; ?>
</div>