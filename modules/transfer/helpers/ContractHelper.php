<?php

namespace modules\transfer\helpers;

use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
use modules\transfer\models\LegalEntityTransfer;
use modules\transfer\models\PersonalEntityTransfer;
use yii\helpers\ArrayHelper;

class ContractHelper
{
    const STATUS_NEW = 0;
    const STATUS_WALT  = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;
    const STATUS_CREATED = 9;
    const STATUS_VIEW = 4;
    const STATUS_SUCCESS = 5;
    const STATUS_SEND_SUCCESS =6;
    const STATUS_NO_REAL = 6;
    const STATUS_FIX = 7;
    const STATUS_ACCEPTED_STUDENT = 8;

    const TYPE_STUDENT = 1;
    const TYPE_PERSONAL =  2;
    const TYPE_LEGAL = 3;


    public static function statusList() {
        return[
            self::STATUS_NEW =>"Новое",
            self::STATUS_WALT=> "Обрабатывается",
            self::STATUS_ACCEPTED =>"Проверен",
            self::STATUS_NO_ACCEPTED =>"Отклонен",
            self::STATUS_VIEW => "Взят в рвботу",
            self::STATUS_CREATED => "Сформировн",
            self::STATUS_SUCCESS => "Подписан",
            self::STATUS_SEND_SUCCESS => "Отправлен на подписание",
            self::STATUS_FIX => 'Отправлен на исправление',
            self::STATUS_ACCEPTED_STUDENT => "Одобрен студентом",
         ];
    }

    public static function statusStudentList() {
        return[
            self::STATUS_NEW =>"Новое",
            self::STATUS_WALT=> "Обрабатывается",
            self::STATUS_ACCEPTED =>"Проверен",
            self::STATUS_VIEW => "Взят в рвботу",
            self::STATUS_NO_ACCEPTED =>"Отклонен",
            self::STATUS_CREATED => "Сформировн",
            self::STATUS_SUCCESS => "Подписан",
            self::STATUS_SEND_SUCCESS => "Отправлен на подписание",
            self::STATUS_FIX => 'Отправлен на исправление',
            self::STATUS_ACCEPTED_STUDENT => "Обрабатывается",
        ];
    }

    public static function typeList() {
         return [
             self::TYPE_STUDENT=> 'Сам обучающийся',
             self::TYPE_PERSONAL => 'Законный представитель обучающегося',
             self::TYPE_LEGAL =>'Юридическое лицо'];
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

    public static function colorAgreementList() {
        return [
            self::STATUS_NEW=> "warning",
            self::STATUS_WALT=> "warning",
            self::STATUS_ACCEPTED =>"success",
            self::STATUS_NO_ACCEPTED =>"danger",
            self::STATUS_VIEW =>"info",
            self::STATUS_SUCCESS => "primary",
            self::STATUS_CREATED => "info",
            self::STATUS_SEND_SUCCESS => "default",
            self::STATUS_FIX => 'warning',
            self::STATUS_ACCEPTED_STUDENT => "warning",
        ];
    }

    public static function colorName($key) {
        return ArrayHelper::getValue(self::colorList(),$key);
    }

    public static function legal($userId) {
        return ArrayHelper::map(LegalEntityTransfer::find()->andWhere(['user_id'=> $userId])->all(),'id', 'name');
    }

    public static function personal($userId)
    {
        return ArrayHelper::map(PersonalEntityTransfer::find()->andWhere(['user_id' => $userId])->all(), 'id', 'fio');
    }


}