<?php

namespace modules\entrant\helpers;

use yii\helpers\ArrayHelper;

class ContractHelper
{
    const STATUS_NEW = 0;
    const STATUS_WALT  = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;
    const STATUS_VIEW =4;
    const STATUS_SUCCESS = 5;
    const STATUS_NO_REAL = 6;

    public static function statusList() {
        return[
            self::STATUS_NEW =>"Новое",
            self::STATUS_ACCEPTED =>"Проверен",
            self::STATUS_NO_ACCEPTED =>"Отклонен",
            self::STATUS_WALT=> "Обрабатывается",
            self::STATUS_VIEW => "Взято в работу",
            self::STATUS_NO_REAL => "Недействительный",
            self::STATUS_SUCCESS => "Подписан",];
    }

    public static function statusName($key) {
        return ArrayHelper::getValue(self::statusList(),$key);
    }

    public static function colorList() {
        return [
            self::STATUS_NEW=> "warning",
            self::STATUS_WALT=> "warning",
            self::STATUS_ACCEPTED =>"success",
            self::STATUS_NO_ACCEPTED =>"danger",
            self::STATUS_NO_REAL =>"danger",
            self::STATUS_SUCCESS => "primary",
            self::STATUS_VIEW => "info"
        ];
    }

       public static function colorName($key) {
        return ArrayHelper::getValue(self::colorList(),$key);
    }


}