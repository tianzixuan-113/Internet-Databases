<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\HistoricalDoc;

class DocController extends Controller
{
    public function actionIndex()
    {
        $docs = HistoricalDoc::find()->orderBy(['doc_id' => SORT_ASC])->all();
        
        return $this->render('index', [
            'docs' => $docs
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