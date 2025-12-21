<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\HeroInfo;
use common\models\WarCampaign;

class HeroController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => HeroInfo::find()->orderBy(['hero_id' => SORT_ASC]),
            'pagination' => ['pageSize' => 20],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $model = new HeroInfo();
        $campaignOptions = \yii\helpers\ArrayHelper::map(WarCampaign::find()->orderBy(['campaign_id' => SORT_ASC])->all(), 'campaign_id', 'campaign_name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '英雄信息已创建。');
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model, 'campaignOptions' => $campaignOptions]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $campaignOptions = \yii\helpers\ArrayHelper::map(WarCampaign::find()->orderBy(['campaign_id' => SORT_ASC])->all(), 'campaign_id', 'campaign_name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '英雄信息已更新。');
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model, 'campaignOptions' => $campaignOptions]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = HeroInfo::findOne($id)) !== null) { return $model; }
        throw new NotFoundHttpException('请求的英雄不存在。');
    }
}
