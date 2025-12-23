<?php

namespace common\models;

use yii\db\ActiveRecord;

class HistoricalDoc extends ActiveRecord
{
    public static function tableName()
    {
        return 'historical_doc';
    }

    public static function primaryKey()
    {
        return ['doc_id'];
    }

    public function rules()
    {
        return [
            [['doc_name'], 'required'],
            [['doc_summary'], 'string'],
            [['related_campaign_id'], 'integer'],
            [['doc_name'], 'string', 'max' => 200],
            [['doc_type'], 'string', 'max' => 50],
        ];
    }
}
