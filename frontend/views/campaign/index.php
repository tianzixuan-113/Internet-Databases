<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $campaigns common\models\WarCampaign[] */

$this->title = '战役历史';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="campaign-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($campaigns)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>战役名称</th>
                        <th>时间</th>
                        <th>地点</th>
                        <th>参战方</th>
                        <th>结果</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($campaigns as $campaign): ?>
                        <tr>
                            <td><?= Html::encode($campaign->campaign_name) ?></td>
                            <td>
                                <?= $campaign->start_time ?> 
                                <?php if ($campaign->end_time): ?> 
                                    至 <?= $campaign->end_time ?> 
                                <?php endif; ?>
                            </td>
                            <td><?= Html::encode($campaign->location) ?></td>
                            <td><?= Html::encode($campaign->warring_parties) ?></td>
                            <td><?= Html::encode($campaign->result) ?></td>
                            <td>
                                <?= Html::a('查看详情', ['campaign/view', 'id' => $campaign->campaign_id], ['class' => 'btn btn-primary']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>暂无战役数据。</p>
    <?php endif; ?>
</div>