<?php

namespace olympic\helpers;


use olympic\models\Diploma;

class DiplomaHelper
{
    public static function diplomaId($user_id, $olympic_id): string
    {
        $model = self::userDiploma($user_id, $olympic_id);
        return $model ? $model->id : "";
    }

    public static function userDiploma($user_id, $olympic_id) {
        return Diploma::findOne(['user_id'=> $user_id, "olimpic_id"=> $olympic_id]);
    }
}