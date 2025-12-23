<?php
use yii\helpers\Html;

/** @var array $groups */
/** @var string $q */

$this->title = '战役时间轴';
$this->params['breadcrumbs'][] = ['label' => '战役管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.tl { position:relative; margin:10px 0; }
.tl::before { content:''; position:absolute; left:120px; top:0; bottom:0; width:2px; background:#e5e5e5; }
.tl-year { position:relative; padding-left:160px; margin-bottom:18px; }
.tl-year__badge { position:absolute; left:0; top:0; width:110px; text-align:right; font-weight:700; color:#666; }
.tl-card { margin:8px 0; padding:10px 12px; background:#fff; border:1px solid #eee; border-radius:6px; box-shadow:0 1px 2px rgba(0,0,0,.03); }
.tl-card__title { font-weight:600; color:#333; }
.tl-card__meta { color:#999; font-size:12px; margin-top:4px; }
.tl-card__desc { color:#555; margin-top:6px; font-size:13px; }
</style>

<div class="campaign-timeline">
    <div style="display:flex; gap:8px; align-items:center; margin-bottom:10px;">
        <a class="btn btn-default" href="<?= Html::encode(\yii\helpers\Url::to(['index'])) ?>">切换为列表</a>
        <?= Html::beginForm(['timeline'], 'get', ['class' => 'form-inline', 'style' => 'display:flex; gap:8px;']) ?>
            <input type="text" class="form-control" name="q" value="<?= Html::encode($q) ?>" placeholder="按名称/地点/描述搜索">
            <button class="btn btn-primary" type="submit">过滤</button>
        <?= Html::endForm() ?>
    </div>

    <div class="tl">
        <?php foreach ($groups as $year => $rows): ?>
            <div class="tl-year">
                <div class="tl-year__badge"><?= Html::encode($year) ?></div>
                <?php foreach ($rows as $c): ?>
                    <div class="tl-card">
                        <div class="tl-card__title">
                            <a href="<?= Html::encode(\yii\helpers\Url::to(['view','id'=>$c->campaign_id])) ?>"><?= Html::encode($c->campaign_name) ?></a>
                        </div>
                        <div class="tl-card__meta">
                            <?= Html::encode($c->start_time ?: '未知开始') ?> — <?= Html::encode($c->end_time ?: '未知结束') ?>
                            <?php if ($c->location): ?> · 地点：<?= Html::encode($c->location) ?><?php endif; ?>
                        </div>
                        <?php if (trim((string)$c->description) !== ''): ?>
                        <div class="tl-card__desc"><?= Html::encode(mb_substr((string)$c->description, 0, 160)) ?><?= mb_strlen((string)$c->description) > 160 ? '…' : '' ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
