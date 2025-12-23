<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\HistoricalDoc;
use common\models\WarCampaign;

class DocController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [[ 'allow' => true, 'roles' => ['@'] ]],
            ],
            'verbs' => [ 'class' => VerbFilter::className(), 'actions' => ['delete' => ['POST']] ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => HistoricalDoc::find()->orderBy(['doc_id' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionTimeline($q = '')
    {
        $q = trim((string)$q);
        $docs = HistoricalDoc::find()->all();
        // 预取战役以便映射年份
        $campaigns = WarCampaign::find()->indexBy('campaign_id')->all();

        $groups = [];
        foreach ($docs as $d) {
            $year = '未知年份';
            if ($d->related_campaign_id && isset($campaigns[$d->related_campaign_id])) {
                $st = $campaigns[$d->related_campaign_id]->start_time;
                if ($st) {
                    $y = (int)date('Y', strtotime($st));
                    if ($y > 0) { $year = (string)$y; }
                }
            }
            if ($q !== '') {
                $hay = ($d->doc_name . ' ' . ($d->doc_summary ?? '') . ' ' . ($d->doc_type ?? ''));
                if (mb_stripos($hay, $q) === false) continue;
            }
            $groups[$year][] = $d;
        }
        ksort($groups); // 年份升序
        return $this->render('timeline', [
            'groups' => $groups,
            'q' => $q,
            'campaigns' => $campaigns,
        ]);
    }

    public function actionCreate()
    {
        $model = new HistoricalDoc();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '史料文献已创建。');
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '史料文献已更新。');
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = HistoricalDoc::findOne($id)) !== null) { return $model; }
        throw new NotFoundHttpException('请求的文献不存在。');
    }
}
