<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\HistoricalDoc;
use common\models\WarCampaign;

class DocController extends Controller
{
    public function actionIndex()
    {
        $docs = HistoricalDoc::find()->orderBy(['doc_id' => SORT_ASC])->all();
        // 战役映射用于推导年份
        $campaigns = WarCampaign::find()->indexBy('campaign_id')->all();
        return $this->render('index', [
            'docs' => $docs,
            'campaigns' => $campaigns,
        ]);
    }
    
    public function actionView($id)
    {
        $model = HistoricalDoc::findOne($id);
        
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('文献信息不存在');
        }
        
        return $this->render('view', [
            'model' => $model
        ]);
    }
}