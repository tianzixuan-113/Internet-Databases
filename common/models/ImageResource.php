<?php

namespace common\models;

use yii\db\ActiveRecord;

class ImageResource extends ActiveRecord
{
    public static function tableName()
    {
        return 'image_resource';
    }

    public static function primaryKey()
    {
        return ['img_id'];
    }

    public function rules()
    {
        return [
            [['img_url', 'related_id'], 'required'],
            [['related_id'], 'integer'],
            [['img_url'], 'string', 'max' => 500],
            [['img_desc'], 'string', 'max' => 200],
        ];
    }
}
