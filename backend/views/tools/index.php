<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var bool $cleared */
/** @var string $logTail */
/** @var array $probes */

$this->title = '系统工具';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tools-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $msg): ?>
        <div class="alert alert-<?= Html::encode($type) ?>"><?= Html::encode($msg) ?></div>
    <?php endforeach; ?>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">缓存与资产</div>
                <div class="panel-body">
                    <p>清理应用缓存与前端资产目录，解决缓存导致的显示异常。</p>
                    <?= Html::beginForm(['index'], 'post') ?>
                        <?= Html::hiddenInput('action', 'clearCache') ?>
                        <button class="btn btn-warning" onclick="return confirm('确认清理缓存与资产？');">一键清理</button>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">查看日志尾部</div>
                <div class="panel-body">
                    <?= Html::beginForm(['index'], 'post', ['class' => 'form-inline']) ?>
                        <?= Html::hiddenInput('action', 'tailLog') ?>
                        <button class="btn btn-primary">刷新日志</button>
                    <?= Html::endForm() ?>
                    <pre style="max-height:300px; overflow:auto; margin-top:10px; background:#111; color:#eee; padding:10px;"><?= Html::encode($logTail) ?></pre>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">批量探测图片/链接</div>
        <div class="panel-body">
            <p>每行一个URL（最多20个），用于检查可达性与类型。</p>
            <?= Html::beginForm(['index'], 'post') ?>
                <?= Html::hiddenInput('action', 'probe') ?>
                <div class="form-group">
                    <textarea name="urls" class="form-control" rows="4" placeholder="https://example.com/a.jpg&#10;img.host/b.png"></textarea>
                </div>
                <div class="form-group" style="margin-top:8px;">
                    <button class="btn btn-success">开始探测</button>
                </div>
            <?= Html::endForm() ?>

            <?php if ($probes): ?>
                <div class="table-responsive" style="margin-top:10px;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>URL</th>
                                <th>状态码</th>
                                <th>类型</th>
                                <th>大小(bytes)</th>
                                <th>结果</th>
                                <th>错误</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($probes as $r): ?>
                            <tr>
                                <td style="max-width:360px; word-break:break-all;"><?= Html::encode($r['url']) ?></td>
                                <td><?= Html::encode((string)$r['status']) ?></td>
                                <td><?= Html::encode($r['contentType']) ?></td>
                                <td><?= Html::encode((string)$r['bytes']) ?></td>
                                <td><?= $r['ok'] ? '<span class="label label-success">OK</span>' : '<span class="label label-default">FAIL</span>' ?></td>
                                <td><?= Html::encode($r['error']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
