<?php

namespace common\models;

use yii\db\ActiveRecord;

class DataStatistics extends ActiveRecord
{
    public static function tableName()
    {
        return 'data_statistics';
    }

    public static function primaryKey()
    {
        return ['stat_id'];
    }

    public function rules()
    {
        return [
            [['stat_type', 'stat_year', 'stat_count'], 'required'],
            [['stat_year', 'stat_count'], 'integer'],
            [['stat_type'], 'string', 'max' => 50],
        ];
    }
}
