<?php
namespace modules\exam\helpers;
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

    public static function listTypes ()
    {
        return [
            self::USUAL_TYPE_OCH  => "Основной",
            self::USUAL_TYPE_ZA_OCH  => "Основной (заочная форма)",
            self::RESERVE_TYPE => "Резервный",
        ];
    }


    public static function listStatus ()
    {
        return [
            self::WALT_STATUS => "Ожидание",
            self::SUCCESS_STATUS => "Допущен",
            self::ERROR_RESERVE_STATUS => "Нарушение/Резервный",
            self::END_STATUS => "Завершен",
            self::RESERVE_STATUS => "Рассмотрен"
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
        ];
    }

    public static function entrantList() {
        return ExamStatement::find()->joinWith('profileEntrant')
            ->select(['CONCAT(first_name, \' \', last_name, \' \', patronymic)', 'entrant_user_id'])
            ->indexBy('entrant_user_id')->column();
    }

    public static function proctorList() {
        return ExamStatement::find()->joinWith('profileProctor')
            ->select(['CONCAT(first_name, \' \', last_name, \' \', patronymic)', 'entrant_user_id'])
            ->indexBy('entrant_user_id')->column();
    }
}