<?php
use yii\grid\GridView; use yii\helpers\Html;
$this->title = '图片资源管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">
<h1><?= Html::encode($this->title) ?></h1>
<p>
    <?= Html::a('新增图片', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('切换为画廊', ['gallery'], ['class' => 'btn btn-default']) ?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
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
                    'style' => 'max-width:120px;max-height:80px',
                    'referrerpolicy' => 'no-referrer',
                    'loading' => 'lazy',
                    'onerror' => "if(!this.dataset.retry && this.src.indexOf('http://')===0){this.dataset.retry=1;this.src=this.src.replace(/^http:/,'https:');}else{this.onerror=null;this.src='data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';}"
                ]);
                return Html::a($img, $url, ['target' => '_blank']);
            }
        ],
        'img_desc',
        'related_id',
        ['class' => 'yii\\grid\\ActionColumn'],
    ],
]) ?>
</div>
