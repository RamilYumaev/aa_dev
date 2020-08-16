<?php

namespace modules\exam\helpers;

use modules\exam\models\ExamAttempt;

class ExamAttemptHelper
{
    const NO_END_TEST = 0;
    const END_TEST = 1;


    public static function count($test)
    {
        return ExamAttempt::find()->test($test)->count();
    }

    public static function isAttempt($test, $user)
    {
        return ExamAttempt::find()->test($test)->user($user)->exists();
    }

    public static function Attempt($test, $user)
    {
        return ExamAttempt::find()->test($test)->user($user)->one();
    }
}