<?php


namespace modules\entrant\helpers;

class ReceiptHelper
{
    const PERIOD_YEAR = 3;
    const PERIOD_M_6 = 2;
    const PERIOD_M_3 = 1;

    public static function listPeriod ($cost) {
        return [
            self::PERIOD_M_3  =>  "по месяцам (".self::cost($cost,self::listSep()[self::PERIOD_M_3]).")",
            self::PERIOD_M_6  => "за семестр (".self::cost($cost, self::listSep()[self::PERIOD_M_6]).")",
            self::PERIOD_YEAR =>"за 1 год (".self::cost($cost,self::listSep()[self::PERIOD_YEAR]).")"];
    }

    public static function listSep () {
        return [
            self::PERIOD_M_3  => 12,
            self::PERIOD_M_6  => 2,
            self::PERIOD_YEAR =>1,
            ];
    }

    public static function cost($cost, $sep) {
        return \Yii::$app->formatter->asCurrency(round($cost/$sep,2));
    }

    public static function costDefault($cost, $sep) {
        return \Yii::$app->formatter->asDecimal(round($cost/$sep,2),2);
    }

}