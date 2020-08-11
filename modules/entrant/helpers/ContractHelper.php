<?php

namespace modules\entrant\helpers;

use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
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

    public static function statusReceiptList() {
        return[
            self::STATUS_NEW =>"Новая",
            self::STATUS_ACCEPTED =>"Проверена",
            self::STATUS_NO_ACCEPTED =>"Отклонена",
            self::STATUS_WALT=> "Обрабатывается",
            self::STATUS_VIEW => "Взято в работу",
            self::STATUS_NO_REAL => "Недействительная",
            self::STATUS_SUCCESS => "Подписан",];
    }

    public static function statusReceiptName($key) {
        return ArrayHelper::getValue(self::statusReceiptList(),$key);
    }

    public static function colorList() {
        return [
            self::STATUS_NEW=> "warning",
            self::STATUS_WALT=> "warning",
            self::STATUS_ACCEPTED =>"success",
            self::STATUS_NO_ACCEPTED =>"danger",
            self::STATUS_NO_REAL =>"default",
            self::STATUS_SUCCESS => "primary",
            self::STATUS_VIEW => "info"
        ];
    }

    public static function colorName($key) {
        return ArrayHelper::getValue(self::colorList(),$key);
    }

    public static function statusAisList() {
        return [
            self::STATUS_NO_REAL =>3,
            self::STATUS_SUCCESS => 2,
        ];
    }

    public static function statusAisNumber($key) {
        return ArrayHelper::getValue(self::statusAisList(),$key);
    }

    public static function legal($userId) {
        return ArrayHelper::map(LegalEntity::find()->andWhere(['user_id'=> $userId])->all(),'id', 'name');
    }

    public static function personal($userId)
    {
        return ArrayHelper::map(PersonalEntity::find()->andWhere(['user_id' => $userId])->all(), 'id', 'fio');
    }


}