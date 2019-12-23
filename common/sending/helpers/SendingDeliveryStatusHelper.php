<?php

namespace common\sending\helpers;
use common\sending\models\SendingDeliveryStatus;
use yii\helpers\ArrayHelper;

class SendingDeliveryStatusHelper
{
    const STATUS_SEND = 1;
    const STATUS_READ = 2;
    const STATUS_NO_EMAIL = 3;

    const TYPE_SEND_INVITATION = 1;
    const TYPE_SEND_DIPLOMA = 2;
    const TYPE_SEND_CONFIRM = 3;

    const TYPE_OLYMPIC = 1;
    const TYPE_MASTER_CLASS = 3;
    const TYPE_DOD = 2;


    public static function deliveryTypeList()
    {
        return [
            self::TYPE_SEND_INVITATION => 'Приглашение',
            self::TYPE_SEND_DIPLOMA => "Диплом/сертификат",
            self::TYPE_SEND_CONFIRM => "Подтвержение"
        ];
    }

    public static function deliveryTypeName($key): string
    {
        return ArrayHelper::getValue(self::deliveryTypeList(), $key);
    }


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

    public static function countInvitation($olympic_id): string
    {
        return SendingDeliveryStatus::find()->typeSending(self::TYPE_SEND_INVITATION)->type(self::TYPE_OLYMPIC)->value($olympic_id)->count();
    }



}