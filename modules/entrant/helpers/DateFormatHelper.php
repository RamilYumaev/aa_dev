<?php

namespace modules\entrant\helpers;


class DateFormatHelper
{
    const DATE_FORMAT = 'Y-m-d';
    const DATE_FORMAT_VIEW = 'd.m.Y';

    private  static function dateFormat($date, $format) : ? string
    {
        return date($format, strtotime($date));
    }

    public static function formatRecord($date) : ? string
    {
        return date(self::DATE_FORMAT, strtotime($date));
    }

    public static function formatView($date) : ? string
    {
        return date(self::DATE_FORMAT_VIEW, strtotime($date));
    }

    public static  function  dateSettingWidget() : array
    {
        return [
            'language' => 'ru',
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd.mm.yyyy'
            ]];
    }



}