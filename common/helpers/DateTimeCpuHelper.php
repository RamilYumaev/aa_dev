<?php
namespace common\helpers;

class DateTimeCpuHelper
{
    public static function getDateChpu($date)
    {
        $month = [
            "01" => "января",
            "02" => "февраля",
            "03" => "марта",
            "04" => "апреля",
            "05" => "мая",
            "06" => "июня",
            "07" => "июля",
            "08" => "августа",
            "09" => "сентября",
            "10" => "октября",
            "11" => "ноября",
            "12" => "декабря"];
        $dt = \Yii::$app->formatter->asDate($date, 'php:d')
            . ' ' . $month[\Yii::$app->formatter->asDate($date, 'php:m')]
            . ' ' . \Yii::$app->formatter->asDate($date, 'php:Y');
        return $dt;

    }

    public static function getTimeChpu($time)
    {
        $tm = \Yii::$app->formatter->asDate($time, 'php:H') . ':' . \Yii::$app->formatter->asDate($time, 'php:i');

        return $tm;
    }
}