<?php

namespace olympic\helpers\auth;

use http\Exception\RuntimeException;
use olympic\models\auth\Profiles;
use phpDocumentor\Reflection\Types\String_;
use Yii;
use yii\web\HttpException;

class ProfileHelper
{
    public static function profileShortName($userId): string
    {
        $profile = self::findProfile($userId);

        return $profile->last_name . " "
            . mb_substr($profile->first_name, 0, 1, 'utf-8') . "."
            . mb_substr($profile->patronymic, 0, 1, 'utf-8') . ".";
    }

    public static function profileFullName($userId): string
    {
        $profile = self::findProfile($userId);

        return $profile->last_name . " "
            . $profile->first_name ." "
            . $profile->patronymic;
    }

    public static function findProfile($userId)
    {
        try {
            return Profiles::find()->andWhere(['user_id' => $userId])->limit('1')->one();

        } catch (\RuntimeException $e) {
            throw new \RuntimeException('Не найден профиль');
        }
    }

}
