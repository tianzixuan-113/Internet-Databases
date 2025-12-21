<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\MemberInfo;
use common\models\TeamInfo;

class MemberController extends Controller
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
            'query' => MemberInfo::find(),
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
        $model = new MemberInfo();
        $teamOptions = \yii\helpers\ArrayHelper::map(TeamInfo::find()->orderBy(['team_id' => SORT_ASC])->all(), 'team_id', 'team_name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '成员信息已创建。');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'teamOptions' => $teamOptions,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $teamOptions = \yii\helpers\ArrayHelper::map(TeamInfo::find()->orderBy(['team_id' => SORT_ASC])->all(), 'team_id', 'team_name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '成员信息已更新。');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'teamOptions' => $teamOptions,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', '成员信息已删除。');
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
        if (($model = MemberInfo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请求的成员不存在。');
    }
}
