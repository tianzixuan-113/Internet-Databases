<?php

namespace common\models;

use yii\db\ActiveRecord;

class Permission extends ActiveRecord
{
    public static function tableName()
    {
        return 'permission';
    }

    public static function primaryKey()
    {
        return ['perm_id'];
    }

    public function rules()
    {
        return [
            [['member_id', 'perm_level'], 'required'],
            [['member_id'], 'integer'],
            [['perm_level'], 'string', 'max' => 20],
            [['perm_desc'], 'string', 'max' => 100],
        ];
    }
}
