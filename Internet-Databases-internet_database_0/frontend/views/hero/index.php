<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $heroes common\models\HeroInfo[] */

$this->title = '抗战英雄';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="hero-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($heroes)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>英雄姓名</th>
                        <th>籍贯</th>
                        <th>所属军队</th>
                        <th>参与战役</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($heroes as $hero): ?>
                        <tr>
                            <td><?= Html::encode($hero->hero_name) ?></td>
                            <td><?= Html::encode($hero->native_place) ?></td>
                            <td><?= Html::encode($hero->army) ?></td>
                            <td>
                                <?php if ($hero->campaign): ?>
                                    <?= Html::encode($hero->campaign->campaign_name) ?>
                                <?php else: ?>
                                    未指定
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= Html::a('查看详情', ['hero/view', 'id' => $hero->hero_id], ['class' => 'btn btn-primary']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>暂无英雄数据。</p>
    <?php endif; ?>
</div>