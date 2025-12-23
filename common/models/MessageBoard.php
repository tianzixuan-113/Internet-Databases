<?php

namespace common\models;

use yii\db\ActiveRecord;

class MessageBoard extends ActiveRecord
{
    public static function tableName()
    {
        return 'message_board';
    }

    public function rules()
    {
        return [
            [['nickname', 'content'], 'required'],
            [['content'], 'string'],
            [['msg_time'], 'safe'],
            [['nickname'], 'string', 'max' => 50],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert && empty($this->msg_time)) {
                $this->msg_time = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }
}
