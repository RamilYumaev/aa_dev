<?php

namespace olympic\helpers;


use olympic\models\Diploma;

class DiplomaHelper
{
    public static function diplomaId($user_id, $olympic_id): ? Diploma
    {
        $model = self::userDiploma($user_id, $olympic_id);
        return $model ? $model : null;
    }

    public static function userDiploma($user_id, $olympic_id) {
        return Diploma::findOne(['user_id'=> $user_id, "olimpic_id"=> $olympic_id]);
    }


}