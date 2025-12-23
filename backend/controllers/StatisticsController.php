<?php

namespace backend\controllers;

use Yii;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use common\models\DataStatistics;
use common\models\WarCampaign;

class StatisticsController extends Controller
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
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => DataStatistics::find()->orderBy(['stat_year' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new DataStatistics();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '统计数据已创建。');
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = DataStatistics::findOne($id);
        if (!$model) { throw new \yii\web\NotFoundHttpException('记录不存在'); }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '统计数据已更新。');
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        if (($model = DataStatistics::findOne($id)) !== null) { $model->delete(); }
        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        if (($model = DataStatistics::findOne($id)) === null) {
            throw new \yii\web\NotFoundHttpException('记录不存在');
        }
        return $this->render('view', ['model' => $model]);
    }

    // 重新计算“战役年份统计”，将聚合结果写入 data_statistics 并返回 JSON
    public function actionRecomputeCampaignYears()
    {
        $type = '战役年份统计';
        $rows = (new \yii\db\Query())
            ->select([
                'stat_year' => new Expression('YEAR(start_time)'),
                'stat_count' => new Expression('COUNT(*)')
            ])
            ->from(WarCampaign::tableName())
            ->groupBy(['YEAR(start_time)'])
            ->orderBy(['YEAR(start_time)' => SORT_ASC])
            ->all();

        DataStatistics::deleteAll(['stat_type' => $type]);
        $inserted = 0;
        foreach ($rows as $r) {
            $m = new DataStatistics();
            $m->stat_type = $type;
            $m->stat_year = (int)$r['stat_year'];
            $m->stat_count = (int)$r['stat_count'];
            if ($m->save(false)) { $inserted++; }
        }

        return $this->asJson(['ok' => true, 'type' => $type, 'inserted' => $inserted]);
    }

    public function asJson($data)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }
}
