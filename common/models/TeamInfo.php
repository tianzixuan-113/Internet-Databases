<?php

namespace common\models;

use yii\db\ActiveRecord;

class TeamInfo extends ActiveRecord
{
    public static function tableName()
    {
        return 'team_info';
    }

    public function rules()
    {
        return [
            [['team_name', 'project_topic'], 'required'],
            [['division_work'], 'string'],
            [['create_time'], 'safe'],
            [['team_name'], 'string', 'max' => 50],
            [['project_topic'], 'string', 'max' => 100],
        ];
    }
}
