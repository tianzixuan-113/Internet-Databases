<?php

namespace common\models;

use yii\db\ActiveRecord;

class PublishInfo extends ActiveRecord
{
    public static function tableName()
    {
        return 'publish_info';
    }

    public function rules()
    {
        return [
            [['title', 'content', 'publisher_id'], 'required'],
            [['content'], 'string'],
            [['publish_time'], 'safe'],
            [['publisher_id'], 'integer'],
            [['title'], 'string', 'max' => 200],
        ];
    }
}
