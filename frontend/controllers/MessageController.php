<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\MessageBoard;

class MessageController extends Controller
{
    public function actionIndex()
    {
        $model = new MessageBoard();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        }
        
        $messages = MessageBoard::find()->orderBy(['msg_id' => SORT_DESC])->all();
        
        return $this->render('index', [
            'model' => $model,
            'messages' => $messages
        ]);
    }
}