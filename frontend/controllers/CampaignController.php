<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\WarCampaign;

class CampaignController extends Controller
{
    public function actionIndex()
    {
        $campaigns = WarCampaign::find()->orderBy(['start_time' => SORT_ASC])->all();
        
        return $this->render('index', [
            'campaigns' => $campaigns
        ]);
    }
    
    public function actionView($id)
    {
        $model = WarCampaign::findOne($id);
        
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('战役信息不存在');
        }
        
        return $this->render('view', [
            'model' => $model
        ]);
    }
}