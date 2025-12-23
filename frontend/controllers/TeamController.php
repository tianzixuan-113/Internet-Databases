<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\TeamInfo;
use common\models\MemberInfo;

class TeamController extends Controller
{
    public function actionIndex()
    {
        $team = TeamInfo::find()->orderBy(['team_id' => SORT_ASC])->one();
        $members = MemberInfo::find()->orderBy(['member_id' => SORT_ASC])->all();
        
        return $this->render('index', [
            'team' => $team,
            'members' => $members
        ]);
    }
}