<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\ImageResource;

class ImageController extends Controller
{
    public function actionIndex()
    {
        $images = ImageResource::find()->all();
        
        return $this->render('index', [
            'images' => $images
        ]);
    }
    
    public function actionSearch()
    {
        $keyword = Yii::$app->request->get('keyword', '');
        
        $query = ImageResource::find();
        if (!empty($keyword)) {
            $query->where(['like', 'img_desc', $keyword]);
        }
        $images = $query->all();
        
        return $this->render('index', [
            'images' => $images,
            'keyword' => $keyword
        ]);
    }
}