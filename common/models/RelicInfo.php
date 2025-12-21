<?php

namespace common\models;

use yii\db\ActiveRecord;

class RelicInfo extends ActiveRecord
{
    public static function tableName()
    {
        return 'relic_info';
    }

    public static function primaryKey()
    {
        return ['relic_id'];
    }

    public function rules()
    {
        return [
            [['relic_name'], 'required'],
            [['description'], 'string'],
            [['relic_name'], 'string', 'max' => 100],
            [['relic_type', 'age'], 'string', 'max' => 50],
            [['collection_place'], 'string', 'max' => 200],
        ];
    }
}
