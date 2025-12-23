<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\HeroInfo;
use common\models\WarCampaign;

class HeroController extends Controller
{
    public function actionIndex()
    {
        $heroes = HeroInfo::find()->orderBy(['hero_id' => SORT_ASC])->all();
        
        return $this->render('index', [
            'heroes' => $heroes
        ]);
    }
    
    public function actionView($id)
    {
        $model = HeroInfo::findOne($id);
        
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('英雄信息不存在');
        }
        
        return $this->render('view', [
            'model' => $model
        ]);
    }
}