<?php


namespace common\auth\helpers;

use common\auth\models\DeclinationFio;

class DeclinationFioHelper
{
    public static function userDeclination($user_id) {
        if(($model = DeclinationFio::findOne(['user_id'=> $user_id])) != null) {
            return $model;
        }
        return null;
    }

}