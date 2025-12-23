<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $q */
/** @var string $host */

$this->title = '图片画廊';
$this->params['breadcrumbs'][] = ['label' => '图片资源', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-gallery">
    <div class="page-actions" style="display:flex; align-items:center; gap:8px; margin-bottom:10px;">
        <a class="btn btn-default" href="<?= Html::encode(\yii\helpers\Url::to(['index'])) ?>">切换为列表</a>
        <?= Html::beginForm(['gallery'], 'get', ['class' => 'form-inline', 'style' => 'display:flex; gap:8px;']) ?>
            <input class="form-control" type="text" name="q" value="<?= Html::encode($q) ?>" placeholder="按URL关键词搜索">
            <input class="form-control" type="text" name="host" value="<?= Html::encode($host) ?>" placeholder="按域名过滤，如 img.host">
            <button class="btn btn-primary" type="submit">过滤</button>
        <?= Html::endForm() ?>
    </div>

    <div class="gallery-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(160px,1fr)); gap:10px;">
        <?php foreach ($dataProvider->getModels() as $m): $url = (string)$m->img_url; ?>
            <a class="gallery-card" href="<?= Html::encode(\yii\helpers\Url::to(['view','id'=>$m->img_id])) ?>" title="ID #<?= Html::encode($m->img_id) ?>" style="display:block; border:1px solid #eee; border-radius:6px; overflow:hidden; background:#fff;">
                <div style="aspect-ratio: 1 / 1; width:100%; background:#f7f7f7; display:flex; align-items:center; justify-content:center;">
                    <img src="<?= Html::encode($url) ?>" referrerpolicy="no-referrer" loading="lazy" style="max-width:100%; max-height:100%; object-fit:cover;" onerror="this.onerror=null; this.src='data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';">
                </div>
                <div style="padding:6px 8px; font-size:12px; color:#666; word-break:break-all;">
                    <?= Html::encode(parse_url($url, PHP_URL_HOST) ?: '') ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="pager" style="margin-top:12px;">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
</div>
