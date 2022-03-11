<?php

namespace common\auth\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\auth\models\User;

class UserHelper
{
    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 10;

    public static function statusList(): array
    {
        return [
            self::STATUS_WAIT => 'Неактивный',
            self::STATUS_ACTIVE => 'Активный',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case self::STATUS_WAIT:
                $class = 'label label-default';
                break;
            case self::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function getAllUserId(): array
    {
        return User::find()->select('id')->column();
    }

    public static function getEmailByUserId($userId)
    {
        $user = User::find()->andWhere(['id' => $userId])->limit('1')->one();

        if ($user) {
            return $user->email;
        }
        return "Нет пользователя";
    }

    public static function isManagerOlympic()
    {
       return \Yii::$app->authManager->getAssignment('olymp_operator',\Yii::$app->user->identity->getId())  ?? false;
    }

    public static function getEmailUserId($userId)
    {
        $user = User::find()->andWhere(['id' => $userId])->limit('1')->one();
        return $user->email ?? null;
    }



}