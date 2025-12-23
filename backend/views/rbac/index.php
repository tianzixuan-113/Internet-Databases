<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User[] $users */
/** @var array $rolesByUser */
/** @var string $q */

$this->title = 'RBAC 角色管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-default" style="margin-bottom:15px;">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['index'], 'options' => ['class' => 'form-inline']]); ?>
                <div class="form-group">
                    <input type="text" class="form-control" name="q" value="<?= Html::encode($q) ?>" placeholder="按ID/用户名/邮箱搜索">
                </div>
                <button class="btn btn-primary" type="submit">搜索</button>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $msg): ?>
        <div class="alert alert-<?= Html::encode($type) ?>"><?= Html::encode($msg) ?></div>
    <?php endforeach; ?>

    <div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>邮箱</th>
                <th>当前角色</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): $roles = $rolesByUser[$u->id] ?? []; ?>
                <tr>
                    <td><?= Html::encode($u->id) ?></td>
                    <td><?= Html::encode($u->username) ?></td>
                    <td><?= Html::encode($u->email) ?></td>
                    <td>
                        <?php if (!$roles): ?>
                            <span class="label label-default">无</span>
                        <?php else: foreach ($roles as $r): ?>
                            <span class="label label-info" style="margin-right:4px;"><?= Html::encode($r) ?></span>
                        <?php endforeach; endif; ?>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <?php if (!in_array('admin', $roles, true)): ?>
                                <?= Html::beginForm(['assign', 'id' => $u->id, 'role' => 'admin'], 'post') ?>
                                <button class="btn btn-xs btn-danger" onclick="return confirm('确认设为管理员？');">设为管理员</button>
                                <?= Html::endForm() ?>
                            <?php else: ?>
                                <?= Html::beginForm(['revoke', 'id' => $u->id, 'role' => 'admin'], 'post') ?>
                                <button class="btn btn-xs btn-default" onclick="return confirm('确认撤销管理员？');">撤销管理员</button>
                                <?= Html::endForm() ?>
                            <?php endif; ?>

                            <?php if (!in_array('editor', $roles, true)): ?>
                                <?= Html::beginForm(['assign', 'id' => $u->id, 'role' => 'editor'], 'post', ['style' => 'display:inline; margin-left:6px;']) ?>
                                <button class="btn btn-xs btn-warning">设为编辑</button>
                                <?= Html::endForm() ?>
                            <?php else: ?>
                                <?= Html::beginForm(['revoke', 'id' => $u->id, 'role' => 'editor'], 'post', ['style' => 'display:inline; margin-left:6px;']) ?>
                                <button class="btn btn-xs btn-default">撤销编辑</button>
                                <?= Html::endForm() ?>
                            <?php endif; ?>

                            <?php if (!in_array('user', $roles, true)): ?>
                                <?= Html::beginForm(['assign', 'id' => $u->id, 'role' => 'user'], 'post', ['style' => 'display:inline; margin-left:6px;']) ?>
                                <button class="btn btn-xs btn-primary">授予用户</button>
                                <?= Html::endForm() ?>
                            <?php else: ?>
                                <?= Html::beginForm(['revoke', 'id' => $u->id, 'role' => 'user'], 'post', ['style' => 'display:inline; margin-left:6px;']) ?>
                                <button class="btn btn-xs btn-default">撤销用户</button>
                                <?= Html::endForm() ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <p class="text-muted">最多显示 200 条，可用搜索精确定位。</p>
</div>
