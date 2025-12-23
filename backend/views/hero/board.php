<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $campaignOptions */
/** @var string $q */
/** @var int|string|null $campaign_id */

$this->title = '英雄看板';
$this->params['breadcrumbs'][] = ['label' => '英雄信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hero-board">
    <div class="page-actions" style="display:flex; align-items:center; gap:8px; margin-bottom:10px;">
        <a class="btn btn-default" href="<?= Html::encode(\yii\helpers\Url::to(['index'])) ?>">切换为列表</a>
        <?= Html::beginForm(['board'], 'get', ['class' => 'form-inline', 'style' => 'display:flex; gap:8px;']) ?>
            <input class="form-control" type="text" name="q" value="<?= Html::encode($q) ?>" placeholder="按姓名/事迹/籍贯搜索">
            <select class="form-control" name="campaign_id">
                <option value="">全部战役</option>
                <?php foreach ($campaignOptions as $id => $name): ?>
                    <option value="<?= Html::encode($id) ?>" <?= (string)$campaign_id === (string)$id ? 'selected' : '' ?>><?= Html::encode($name) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-primary" type="submit">过滤</button>
        <?= Html::endForm() ?>
    </div>

    <div class="card-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(240px,1fr)); gap:12px;">
        <?php foreach ($dataProvider->getModels() as $m): ?>
            <div class="card" style="border:1px solid #eee; border-radius:8px; background:#fff; overflow:hidden; display:flex; flex-direction:column;">
                <div style="padding:10px 12px; display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <div style="font-weight:600; font-size:15px;"><?= Html::encode($m->hero_name) ?></div>
                        <div style="font-size:12px; color:#888; margin-top:2px;">#<?= Html::encode($m->hero_id) ?> · <?= Html::encode($m->native_place ?: '籍贯未知') ?></div>
                    </div>
                    <?php if ($m->campaign_id): ?>
                        <span class="label label-info">战役: <?= Html::encode($m->campaign_id) ?></span>
                    <?php endif; ?>
                </div>
                <div style="padding:0 12px 10px 12px; color:#555; font-size:13px; flex:1;">
                    <?php $deed = trim((string)$m->deed); if ($deed === '') $deed = '无详细事迹记录'; ?>
                    <div style="max-height:72px; overflow:hidden;"><?= Html::encode(mb_substr($deed, 0, 120)) ?><?= mb_strlen($deed) > 120 ? '…' : '' ?></div>
                </div>
                <div style="padding:8px 12px; border-top:1px solid #f0f0f0; display:flex; gap:8px;">
                    <a class="btn btn-xs btn-default" href="<?= Html::encode(\yii\helpers\Url::to(['view','id'=>$m->hero_id])) ?>">查看</a>
                    <a class="btn btn-xs btn-primary" href="<?= Html::encode(\yii\helpers\Url::to(['update','id'=>$m->hero_id])) ?>">编辑</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pager" style="margin-top:12px;">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
</div>
