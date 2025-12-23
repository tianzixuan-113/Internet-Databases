<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="admin-body">
<?php $this->beginBody() ?>

<div class="admin-layout">
    <?php if (!Yii::$app->user->isGuest): ?>
        <aside class="admin-sidebar">
            <div class="admin-sidebar__brand">
                <div class="brand-main">抗战胜利 80 周年</div>
                <div class="brand-sub">后台管理系统</div>
            </div>

            <nav class="admin-sidebar__nav">
                <div class="nav-section">
                    <div class="nav-section__title">核心管理</div>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/team/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'team' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-queen"></span>
                        <span class="nav-item__label">团队信息</span>
                    </a>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/member/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'member' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-user"></span>
                        <span class="nav-item__label">成员管理</span>
                    </a>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/permission/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'permission' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-lock"></span>
                        <span class="nav-item__label">权限管理</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section__title">内容管理</div>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/relic/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'relic' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-tower"></span>
                        <span class="nav-item__label">文物信息</span>
                    </a>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/campaign/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'campaign' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-map-marker"></span>
                        <span class="nav-item__label">战役管理</span>
                    </a>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/hero/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'hero' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-king"></span>
                        <span class="nav-item__label">英雄信息</span>
                    </a>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/doc/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'doc' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-book"></span>
                        <span class="nav-item__label">史料文献</span>
                    </a>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/image/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'image' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-picture"></span>
                        <span class="nav-item__label">图片资源</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section__title">交互管理</div>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/publish/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'publish' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-bullhorn"></span>
                        <span class="nav-item__label">资讯发布</span>
                    </a>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/message/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'message' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-comment"></span>
                        <span class="nav-item__label">留言管理</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section__title">数据分析</div>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/statistics/index'])) ?>" class="nav-item<?= Yii::$app->controller->id === 'statistics' ? ' active' : '' ?>">
                        <span class="nav-item__icon glyphicon glyphicon-stats"></span>
                        <span class="nav-item__label">数据统计</span>
                    </a>
                </div>
            </nav>
        </aside>
    <?php endif; ?>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar__left">
                <div class="admin-topbar__title">后台数据总览</div>
                <div class="admin-topbar__subtitle">抗战纪念 · 数据驱动管理</div>
            </div>
            <div class="admin-topbar__right">
                <?php if (Yii::$app->user->isGuest): ?>
                    <a href="<?= Html::encode(Yii::$app->urlManager->createUrl(['/site/login'])) ?>" class="topbar-link">登录</a>
                <?php else: ?>
                    <span class="topbar-user">欢迎您，<?= Html::encode(Yii::$app->user->identity->username) ?></span>
                    <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'topbar-logout-form']) ?>
                        <button type="submit" class="topbar-link topbar-link--danger">退出</button>
                    <?= Html::endForm() ?>
                <?php endif; ?>
            </div>
        </header>

        <div class="admin-main__content">
            <div class="admin-breadcrumbs">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>

            <?= Alert::widget() ?>
            <?= $content ?>
        </div>

        <footer class="admin-footer">
            <div class="admin-footer__inner">
                <span>&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></span>
                <span class="admin-footer__right"><?= Yii::powered() ?></span>
            </div>
        </footer>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
