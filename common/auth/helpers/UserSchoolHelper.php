<?php

namespace common\auth\helpers;

use common\auth\models\UserSchool;

class UserSchoolHelper
{
    public static function userSchoolId($user_id, $edu_year): string
    {
        return self::userSchool($user_id, $edu_year)->school_id ?? "";
    }

    public static function userClassId($user_id, $edu_year): string
    {
        return  self::userSchool($user_id, $edu_year)->class_id ?? "";
    }

    private static function userSchool($user_id, $edu_year) {
        return UserSchool::findOne(['user_id'=> $user_id, "edu_year"=> $edu_year]);
    }
}