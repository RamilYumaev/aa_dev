<?php

namespace modules\entrant\models;

use common\auth\models\User;
use modules\dictionary\helpers\DictDefaultHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_ais}}".
 *
 * @property integer $user_id
 * @property integer $incoming_id
 **/

class UserAis extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%user_ais}}";
    }

    public static function create($userId, $incomingId) {
        $userAis = new static();
        $userAis->user_id  = $userId;
        $userAis->incoming_id = $incomingId;
        return $userAis;
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id'=>'user_id']);
    }


    public function attributeLabels()
    {
        return ["user_id" => "Юзер ID", 'incoming_id' => "Юзер АИС ID"];
    }

}