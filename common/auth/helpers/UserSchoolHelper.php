<?php

namespace common\auth\helpers;

use common\auth\models\UserSchool;
use dictionary\helpers\DictSchoolsHelper;
use yii\helpers\ArrayHelper;

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

    public static function userSchool($user_id, $edu_year) {
        return UserSchool::findOne(['user_id'=> $user_id, "edu_year"=> $edu_year]);
    }

    public static function userSchoolAll($user_id): array
    {
        return  ArrayHelper::map(UserSchool::find()->select(['school_id'])
            ->where(['user_id'=>$user_id])->groupBy(['school_id'])->asArray()->all(), 'school_id', function ($array) {
            return DictSchoolsHelper::schoolName($array['school_id']);
        });
    }

    public static function userSchoolYear($school_id, $edu_year) {
        return UserSchool::findOne(['school_id'=> $school_id, "edu_year"=> $edu_year]);
    }
}