<?php

namespace common\auth\helpers;

use common\auth\models\UserSchool;

class UserSchoolHelper
{
    public static function userSchoolId($user_id, $edu_year): string
    {
        return  UserSchool::findOne(['user_id'=> $user_id, "edu_year"=> $edu_year])->school_id ?? "";
    }
}