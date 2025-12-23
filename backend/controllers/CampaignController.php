<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\WarCampaign;

class CampaignController extends Controller
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
            'query' => WarCampaign::find()->orderBy(['start_time' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTimeline($q = '')
    {
        $q = trim((string)$q);
        $rows = WarCampaign::find()->orderBy(['start_time' => SORT_ASC])->all();
        $groups = [];
        foreach ($rows as $c) {
            $year = '未知年份';
            if (!empty($c->start_time)) {
                $y = (int)date('Y', strtotime($c->start_time));
                if ($y > 0) $year = (string)$y;
            }
            if ($q !== '') {
                $hay = ($c->campaign_name . ' ' . ($c->location ?? '') . ' ' . ($c->description ?? ''));
                if (mb_stripos($hay, $q) === false) continue;
            }
            $groups[$year][] = $c;
        }
        ksort($groups);
        return $this->render('timeline', [ 'groups' => $groups, 'q' => $q ]);
    }

    public function actionCreate()
    {
        $model = new WarCampaign();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '战役信息已创建。');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '战役信息已更新。');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
        Yii::$app->session->setFlash('success', '战役信息已删除。');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = WarCampaign::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的战役不存在。');
    }
}
