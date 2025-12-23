<?php
use yii\helpers\Html;

/** @var array $groups */
/** @var string $q */
/** @var \common\models\WarCampaign[] $campaigns */

$this->title = '史料时间轴';
$this->params['breadcrumbs'][] = ['label' => '史料文献', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.timeline { position:relative; margin:10px 0; }
.timeline::before { content:''; position:absolute; left:120px; top:0; bottom:0; width:2px; background:#e5e5e5; }
.timeline-year { position:relative; padding-left:160px; margin-bottom:18px; }
.timeline-year__badge { position:absolute; left:0; top:0; width:110px; text-align:right; font-weight:700; color:#666; }
.timeline-card { margin:8px 0 8px 0; padding:10px 12px; background:#fff; border:1px solid #eee; border-radius:6px; box-shadow:0 1px 2px rgba(0,0,0,.03); }
.timeline-card__title { font-weight:600; color:#333; }
.timeline-card__meta { color:#999; font-size:12px; margin-top:4px; }
.timeline-card__summary { color:#555; margin-top:6px; font-size:13px; }
</style>

<div class="doc-timeline">
    <div style="display:flex; gap:8px; align-items:center; margin-bottom:10px;">
        <a class="btn btn-default" href="<?= Html::encode(\yii\helpers\Url::to(['index'])) ?>">切换为列表</a>
        <?= Html::beginForm(['timeline'], 'get', ['class' => 'form-inline', 'style' => 'display:flex; gap:8px;']) ?>
            <input type="text" class="form-control" name="q" value="<?= Html::encode($q) ?>" placeholder="按标题/摘要/类型搜索">
            <button class="btn btn-primary" type="submit">过滤</button>
        <?= Html::endForm() ?>
    </div>

    <div class="timeline">
        <?php foreach ($groups as $year => $rows): ?>
            <div class="timeline-year">
                <div class="timeline-year__badge"><?= Html::encode($year) ?></div>
                <?php foreach ($rows as $d): ?>
                    <div class="timeline-card">
                        <div class="timeline-card__title">
                            <a href="<?= Html::encode(\yii\helpers\Url::to(['view','id'=>$d->doc_id])) ?>"><?= Html::encode($d->doc_name) ?></a>
                        </div>
                        <div class="timeline-card__meta">
                            类型：<?= Html::encode($d->doc_type ?: '未知') ?>
                            <?php if ($d->related_campaign_id && isset($campaigns[$d->related_campaign_id])): ?>
                                · 战役：<?= Html::encode($campaigns[$d->related_campaign_id]->campaign_name) ?>
                            <?php endif; ?>
                        </div>
                        <?php if (trim((string)$d->doc_summary) !== ''): ?>
                        <div class="timeline-card__summary"><?= Html::encode(mb_substr((string)$d->doc_summary, 0, 160)) ?><?= mb_strlen((string)$d->doc_summary) > 160 ? '…' : '' ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
