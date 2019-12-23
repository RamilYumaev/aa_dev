<?php


namespace testing\helpers;


use testing\models\TestAttempt;
use testing\models\TestQuestion;
use yii\helpers\ArrayHelper;

class TestAttemptHelper
{
    public static function count($test){
        return TestAttempt::find()->test($test)->count();
    }

    public static function isAttempt($test, $user){
        return TestAttempt::find()->test($test)->user($user)->exists();
    }


}