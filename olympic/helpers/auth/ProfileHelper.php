<?php

namespace olympic\helpers\auth;

use common\auth\helpers\UserHelper;
use common\auth\models\User;
use http\Exception\RuntimeException;
use olympic\models\auth\Profiles;
use phpDocumentor\Reflection\Types\String_;
use Yii;
use yii\db\Expression;
use yii\web\HttpException;

class ProfileHelper
{
    public static function profileShortName($userId): string
    {
        $profile = self::findProfile($userId);
        if ($profile) {
            return $profile->last_name . " "
                . mb_substr($profile->first_name, 0, 1, 'utf-8') . "."
                . mb_substr($profile->patronymic, 0, 1, 'utf-8') . ".";
        } else {
            return "";
        }

    }

    public static function profileFullName($userId): string
    {
        $profile = self::findProfile($userId);

        if ($profile) {
            return $profile->last_name . " "
                . $profile->first_name . " "
                . $profile->patronymic;
        } else {
            return " ";
        }

    }

    public static function getAllUserFullNameWithEmail()
    {
        return Profiles::find()
            ->select(new Expression("concat_ws(' ', last_name, first_name, patronymic, email)"))
            ->joinWith('user', false)
            ->indexBy("user_id")
            ->column();
    }

    public
    static function findProfile($userId)
    {
        try {
            return Profiles::find()->andWhere(['user_id' => $userId])->limit('1')->one();

        } catch (\RuntimeException $e) {
            throw new \RuntimeException('Не найден профиль');
        }
    }

    public
    static function findUserEmail($userId)
    {
        try {
            return User::find()->select('email')->andWhere(['id' => $userId])->indexBy('id')->column();
        } catch (\RuntimeException $e) {
            throw new \RuntimeException('Не найден ни один пользователь');

        }
    }

}
