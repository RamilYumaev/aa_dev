<?php

namespace olympic\helpers\auth;

use common\auth\helpers\UserHelper;
use common\auth\models\User;
use http\Exception\RuntimeException;
use olympic\models\auth\Profiles;
use phpDocumentor\Reflection\Types\String_;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class ProfileHelper
{
    const ROLE_STUDENT = 0;
    const ROLE_TEACHER = 1;
    const ROLE_OPERATOR = 2;
    const ROLE_ADMIN = 3;

    const ROLE_ENTRANT  = 4;

    const MALE = 1;
    const FEMALE = 2;

    public static function typeOfRole()
    {
        return [
            self::ROLE_ADMIN => 'администратор',
            self::ROLE_OPERATOR => 'менеджер олимпиады',
            self::ROLE_TEACHER => 'учитель/преподаватель',
            self::ROLE_STUDENT => 'ученик/студент',
            self::ROLE_ENTRANT => 'ПK',
        ];
    }

    public static function typeOfGender()
    {
        return [
            self::MALE => 'мужской',
            self::FEMALE => 'женский',
        ];
    }


    public static function genderName($gender): ?string
    {
        return ArrayHelper::getValue(self::typeOfGender(), $gender);
    }


    public static function roleName($role): string
    {
        return ArrayHelper::getValue(self::typeOfRole(), $role);
    }


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

    public static function profileName($userId): string
    {
        $profile = self::findProfile($userId);

        if ($profile) {
            return $profile->first_name . " "
                . $profile->patronymic;
        } else {
            return " ";
        }
    }

    public static function withBestRegard($userId)
    {
        $profile = self::findProfile($userId);
        if ($profile->gender == self::FEMALE) {
            return "Уважаемая";
        }
        if ($profile->gender == self::MALE) {
            return "Уважаемый";
        }

        return "Уважаемый(-ая)";

    }


    public static function getAllUserFullNameWithEmail()
    {
        return Profiles::find()
            ->select(new Expression("concat_ws(' ', last_name, first_name, patronymic, email)"))
            ->joinWith('user', false)
            ->indexBy("user_id")
            ->column();
    }

    public static function findProfile($userId)
    {
        try {
            return Profiles::find()->andWhere(['user_id' => $userId])->limit('1')->one();

        } catch (\RuntimeException $e) {
            throw new \RuntimeException('Не найден профиль');
        }
    }

    public static function isDataNoEmpty($userId)
    {
        return Profiles::findOne(['user_id' => $userId])->isDataNoEmpty();
    }


    public static function findUserEmail($userId)
    {
        try {
            return User::find()->select('email')->andWhere(['id' => $userId])->indexBy('id')->column();
        } catch (\RuntimeException $e) {
            throw new \RuntimeException('Не найден ни один пользователь');

        }
    }

    public static function dataArray($userId)
    {
       return Profiles::findOne(['user_id' => $userId])->data();
    }

}
