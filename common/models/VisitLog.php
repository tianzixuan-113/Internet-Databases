<?php
namespace common\models;

use yii\db\ActiveRecord;

class VisitLog extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%visit_log}}';
    }

    public function rules()
    {
        return [
            [['route', 'url', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['route'], 'string', 'max' => 128],
            [['url', 'referer'], 'string', 'max' => 2048],
            [['ip'], 'string', 'max' => 45],
            [['ua'], 'string', 'max' => 255],
        ];
    }
}
