<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\WarCampaign;
use common\models\HeroInfo;
use common\models\HistoricalDoc;

class SearchController extends Controller
{
    public function actionIndex()
    {
        $campaigns = [];
        $heroes = [];
        $docs = [];
        
        $campaignName = Yii::$app->request->get('campaign_name', '');
        $heroName = Yii::$app->request->get('hero_name', '');
        $docName = Yii::$app->request->get('doc_name', '');
        
        // 搜索战役数据
        if (!empty($campaignName)) {
            $campaigns = WarCampaign::find()
                ->where(['like', 'campaign_name', $campaignName])
                ->all();
        }
        
        // 搜索英雄数据
        if (!empty($heroName)) {
            $heroes = HeroInfo::find()
                ->where(['like', 'hero_name', $heroName])
                ->all();
        }
        
        // 搜索史料文献数据
        if (!empty($docName)) {
            $docs = HistoricalDoc::find()
                ->where(['like', 'doc_name', $docName])
                ->all();
        }
        
        return $this->render('index', [
            'campaigns' => $campaigns,
            'heroes' => $heroes,
            'docs' => $docs,
            'campaignName' => $campaignName,
            'heroName' => $heroName,
            'docName' => $docName
        ]);
    }
    
    public function actionAdvanced()
    {
        $searchModel = new \yii\base\DynamicModel([
            'campaign_name', 
            'location', 
            'start_time_from', 
            'start_time_to',
            'hero_name',
            'native_place',
            'doc_name',
            'doc_type'
        ]);
        
        $searchModel->addRule(['campaign_name', 'location', 'hero_name', 'native_place', 'doc_name', 'doc_type'], 'string')
            ->addRule(['start_time_from', 'start_time_to'], 'safe');
        
        $campaigns = [];
        $heroes = [];
        $docs = [];
        
        if ($searchModel->load(Yii::$app->request->get()) && $searchModel->validate()) {
            // 搜索战役数据
            $campaignQuery = WarCampaign::find();
            if (!empty($searchModel->campaign_name)) {
                $campaignQuery->andFilterWhere(['like', 'campaign_name', $searchModel->campaign_name]);
            }
            if (!empty($searchModel->location)) {
                $campaignQuery->andFilterWhere(['like', 'location', $searchModel->location]);
            }
            if (!empty($searchModel->start_time_from)) {
                $campaignQuery->andFilterWhere(['>=', 'start_time', $searchModel->start_time_from]);
            }
            if (!empty($searchModel->start_time_to)) {
                $campaignQuery->andFilterWhere(['<=', 'start_time', $searchModel->start_time_to]);
            }
            $campaigns = $campaignQuery->all();
            
            // 搜索英雄数据
            $heroQuery = HeroInfo::find();
            if (!empty($searchModel->hero_name)) {
                $heroQuery->andFilterWhere(['like', 'hero_name', $searchModel->hero_name]);
            }
            if (!empty($searchModel->native_place)) {
                $heroQuery->andFilterWhere(['like', 'native_place', $searchModel->native_place]);
            }
            $heroes = $heroQuery->all();
            
            // 搜索史料文献数据
            $docQuery = HistoricalDoc::find();
            if (!empty($searchModel->doc_name)) {
                $docQuery->andFilterWhere(['like', 'doc_name', $searchModel->doc_name]);
            }
            if (!empty($searchModel->doc_type)) {
                $docQuery->andFilterWhere(['doc_type' => $searchModel->doc_type]);
            }
            $docs = $docQuery->all();
        }
        
        return $this->render('advanced', [
            'searchModel' => $searchModel,
            'campaigns' => $campaigns,
            'heroes' => $heroes,
            'docs' => $docs
        ]);
    }
}