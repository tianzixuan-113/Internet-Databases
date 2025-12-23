<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $docs common\models\HistoricalDoc[] */

$this->title = '史料文献';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="doc-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($docs)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>文献名称</th>
                        <th>类型</th>
                        <th>摘要</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docs as $doc): ?>
                        <tr>
                            <td><?= Html::encode($doc->doc_name) ?></td>
                            <td><?= Html::encode($doc->doc_type) ?></td>
                            <td><?= Html::encode($doc->doc_summary) ?></td>
                            <td>
                                <?= Html::a('查看详情', ['doc/view', 'id' => $doc->doc_id], ['class' => 'btn btn-primary']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>暂无文献数据。</p>
    <?php endif; ?>
</div>