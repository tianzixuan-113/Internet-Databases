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
        // 提供战役选项用于前端下拉筛选
        $campaignRows = WarCampaign::find()->orderBy(['campaign_name' => SORT_ASC])->all();
        $campaigns = [];
        foreach ($campaignRows as $c) { $campaigns[$c->campaign_id] = $c->campaign_name; }

        // 采集部队与籍贯选项
        $armiesMap = []; $placesMap = [];
        foreach ($heroes as $h) {
            $army = trim((string)($h->army ?? ''));
            $place = trim((string)($h->native_place ?? ''));
            if ($army !== '') $armiesMap[$army] = true;
            if ($place !== '') $placesMap[$place] = true;
        }
        $armies = array_keys($armiesMap); sort($armies, SORT_NATURAL | SORT_FLAG_CASE);
        $places = array_keys($placesMap); sort($places, SORT_NATURAL | SORT_FLAG_CASE);

        return $this->render('index', [
            'heroes' => $heroes,
            'campaigns' => $campaigns,
            'armies' => $armies,
            'places' => $places,
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