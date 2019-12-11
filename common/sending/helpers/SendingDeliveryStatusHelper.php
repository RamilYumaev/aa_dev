<?php

namespace common\sending\helpers;
use yii\helpers\ArrayHelper;

class SendingDeliveryStatusHelper
{
    const STATUS_SEND = 1;
    const STATUS_READ = 2;
    const STATUS_NO_EMAIL = 3;


    public static function deliveryStatusList()
    {
        return [
            self::STATUS_SEND => 'Отправлено',
            self::STATUS_READ => 'Прочитано',
            self::STATUS_NO_EMAIL => 'Не указан адрен электронной почты',
        ];
    }


    public static function deliveryStatusName($key): string
    {
        return ArrayHelper::getValue(self::deliveryStatusList(), $key);
    }


}