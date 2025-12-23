<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ImageResource */

$this->title = '图片 #' . $model->img_id;
$this->params['breadcrumbs'][] = ['label' => '图片资源管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="image-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->img_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->img_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该图片记录吗？',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'img_id',
            [
                'label' => '图片',
                'format' => 'raw',
                'value' => function($model){
                    $url = trim($model->img_url);
                    if (!preg_match('#^https?://#i', $url)) {
                        $url = 'http://' . ltrim($url, '/');
                    }
                    $img = Html::img($url, [
                        'style' => 'max-width:100%;max-height:400px',
                        'referrerpolicy' => 'no-referrer',
                        'loading' => 'lazy',
                        'onerror' => "if(!this.dataset.retry && this.src.indexOf('http://')===0){this.dataset.retry=1;this.src=this.src.replace(/^http:/,'https:');}else{this.onerror=null;this.src='data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';this.style.objectFit='contain';}"
                    ]);
                    return Html::a($img, $url, ['target' => '_blank']);
                }
            ],
            'img_url:url',
            'img_desc',
            'related_id',
        ],
    ]) ?>
</div>
