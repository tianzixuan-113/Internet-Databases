<?php

namespace common\models;

use yii\db\ActiveRecord;

class WarCampaign extends ActiveRecord
{
    public static function tableName()
    {
        return 'war_campaign';
    }

    public function rules()
    {
        return [
            [['campaign_name'], 'required'],
            [['start_time', 'end_time'], 'safe'],
            [['description'], 'string'],
            [['campaign_name', 'location'], 'string', 'max' => 100],
            [['warring_parties', 'result'], 'string', 'max' => 200],
        ];
    }
}
