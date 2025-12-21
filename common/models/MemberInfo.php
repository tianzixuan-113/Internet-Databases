<?php

namespace common\models;

use yii\db\ActiveRecord;

class MemberInfo extends ActiveRecord
{
    public static function tableName()
    {
        return 'member_info';
    }

    public static function primaryKey()
    {
        return ['member_id'];
    }

    public function rules()
    {
        return [
            [['member_id', 'member_name', 'student_id', 'duty', 'team_id'], 'required'],
            [['member_id', 'team_id'], 'integer'],
            [['introduction'], 'string'],
            [['member_name', 'student_id'], 'string', 'max' => 20],
            [['duty'], 'string', 'max' => 50],
        ];
    }
}
