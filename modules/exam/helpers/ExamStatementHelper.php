<?php
namespace modules\exam\helpers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\exam\models\ExamStatement;

class ExamStatementHelper
{
    const RESERVE_TYPE = 2;
    const USUAL_TYPE_ZA_OCH = 1;
    const USUAL_TYPE_OCH = 0;

    const WALT_STATUS = 0;
    const SUCCESS_STATUS = 1;
    const ERROR_RESERVE_STATUS = 2;
    const END_STATUS = 3;
    const RESERVE_STATUS = 4;
    const CANCEL_STATUS = 5;

    public static function listTypes ()
    {
        return [
            self::USUAL_TYPE_OCH  => "Основной",
            self::USUAL_TYPE_ZA_OCH  => "Основной (заочная форма)",
            self::RESERVE_TYPE => "Резервный",
        ];
    }

    public static function timeList ()
    {
        return [
            "10:00"  => "10:00" ,
            "11:30"  => "11:30" ,
            "14:00"  => "14:00" ,
        ];
    }

    public static function timeSpecList ()
    {
        return [
            "10:00"  => "10:00" ,
            "10:30"  => "10:30" ,
            "11:00"  => "11:00" ,
            "11:30"  => "11:30" ,
            "12:00"  => "12:00" ,
            "12:30"  => "12:30" ,
            "13:00"  => "12:00" ,
            "13:30"  => "13:30" ,
            "14:00"  => "14:00" ,
            "14:30"  => "14:30" ,
            "15:00"  => "15:00" ,
            "15:30"  => "15:30" ,
            "16:00"  => "16:00" ,
            "16:30"  => "16:30" ,
            "17:00"  => "17:00" ,
            "17:30"  => "17:30" ,
            "18:00"  => "18:00" ,
            "18:30"  => "18:30" ,
            "19:00"  => "19:00" ,
            "19:30"  => "19:30" ,
            "20:00"  => "20:00" ,
            "20:30"  => "20:30" ,
            "21:00"  => "21:00" ,
            "21:30"  => "21:30" ,
            "22:00"  => "22:00" ,
            "22:30"  => "22:30" ,
            "23:00"  => "23:00"
        ];
    }




    public static function listStatus ()
    {
        return [
            self::WALT_STATUS => "Ожидание",
            self::SUCCESS_STATUS => "Допущен",
            self::ERROR_RESERVE_STATUS => "Нарушение/Резервный",
            self::END_STATUS => "Завершен",
            self::RESERVE_STATUS => "Перенос на резервный день",
            self::CANCEL_STATUS => "Аннулирован"
        ];
    }

    public static function listStatusColor ()
    {
        return [
            self::WALT_STATUS => "label label-default",
            self::SUCCESS_STATUS => "label label-success",
            self::ERROR_RESERVE_STATUS => "label label-danger",
            self::END_STATUS => "label label-primary",
            self::RESERVE_STATUS => "label label-info",
            self::CANCEL_STATUS => "label label-danger"
        ];
    }

    public static function entrantList() {
        return ExamStatement::find()->joinWith('profileEntrant')
            ->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)', 'entrant_user_id'])
            ->indexBy('entrant_user_id')->column();
    }

    public static function proctorList() {
        return ExamStatement::find()->joinWith('profileProctor')
            ->select(['CONCAT(last_name, \' \', first_name,  \' \', patronymic)', 'proctor_user_id'])
            ->indexBy('proctor_user_id')->column();
    }

}