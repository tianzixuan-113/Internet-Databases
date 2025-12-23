<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '关于本项目';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>本网站为“抗战主题信息展示”教学项目，基于 Yii2 Advanced 模板开发，旨在展示战役、英雄、史料与团队成果。</p>

    <h3>主要功能</h3>
    <ul>
        <li>展示历史战役与相关史料</li>
        <li>英雄与文物信息管理</li>
        <li>资讯发布、留言板与数据统计</li>
        <li>后台管理界面（需登录）用于内容维护</li>
    </ul>

</div>
