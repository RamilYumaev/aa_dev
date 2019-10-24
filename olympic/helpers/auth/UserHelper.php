<?php
<<<<<<< HEAD:common/helpers/UserHelper.php

namespace common\helpers;
=======
namespace olympic\helpers\auth;
>>>>>>> #10:olympic/helpers/auth/UserHelper.php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper
{
    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 10;

    public static function statusList(): array
    {
        return [
            self::STATUS_WAIT => 'Wait',
            self::STATUS_ACTIVE => 'Active',
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
}