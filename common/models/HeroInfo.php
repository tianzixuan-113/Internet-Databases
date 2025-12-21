<?php

namespace common\models;

use yii\db\ActiveRecord;

class HeroInfo extends ActiveRecord
{
    public static function tableName()
    {
        return 'hero_info';
    }

    public static function primaryKey()
    {
        return ['hero_id'];
    }

    public function rules()
    {
        return [
            [['hero_id', 'hero_name', 'campaign_id'], 'required'],
            [['hero_id', 'campaign_id'], 'integer'],
            [['deed'], 'string'],
            [['hero_name'], 'string', 'max' => 100],
            [['native_place', 'army'], 'string', 'max' => 100],
        ];
    }

    public function getCampaign()
    {
        return $this->hasOne(WarCampaign::class, ['campaign_id' => 'campaign_id']);
    }
}
