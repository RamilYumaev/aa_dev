<?php

namespace modules\entrant\helpers;


use kartik\date\DatePicker;

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

    public static function intDateYear(): int {
        return (int) date("Y");
    }

    public static  function  dateSettingWidget() : array
    {
        return [
            'language' => 'ru',
            'pluginOptions' => [
                'endDate' => '+0d',
                'autoclose'=>true,
                'format' => 'dd.mm.yyyy'
            ]];
    }

    public static  function  dateSettingStartWidget() : array
    {
        return [
            'language' => 'ru',
            'pluginOptions' => [
                'startDate' => '+0d',
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
            ]];
    }

    public static function dateWidgetRangeSearch($searchModel, $from, $to, $type = DatePicker::TYPE_RANGE) {
        return DatePicker::widget([
            'language' => 'ru',
            'model' => $searchModel,
            'attribute' => $from,
            'attribute2' => $to,
            'type' => $type,
            'separator' => '-',
            'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
            ],
        ]);

    }


}