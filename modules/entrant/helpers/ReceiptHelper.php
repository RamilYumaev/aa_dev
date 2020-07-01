<?php


namespace modules\entrant\helpers;

class ReceiptHelper
{
    const PERIOD_YEAR = 3;
    const PERIOD_M_6 = 2;
    const PERIOD_M_3 = 1;

    public static function listPeriod ($cost) {
        return [
            self::PERIOD_M_3  =>  "на  3 месяца (".self::cost($cost,self::listSep()[self::PERIOD_M_3]).")",
            self::PERIOD_M_6  => "на 6 месяцев (".self::cost($cost, self::listSep()[self::PERIOD_M_6]).")",
            self::PERIOD_YEAR =>"на 1 год (".self::cost($cost,self::listSep()[self::PERIOD_YEAR]).")"];
    }

    public static function listSep () {
        return [
            self::PERIOD_M_3  => 4,
            self::PERIOD_M_6  => 2,
            self::PERIOD_YEAR =>1,
            ];
    }


    public static function cost($cost, $sep) {
        return \Yii::$app->formatter->asCurrency(round($cost/$sep,2));
    }

}