<?php
namespace modules\entrant\helpers;

use yii\helpers\ArrayHelper;

class AddressHelper
{
    const TYPE_ACTUAL = 1;
    const TYPE_REGISTRATION = 2;
    const TYPE_RESIDENCE= 3;

    public static function typeOfAddress()
    {
        return [
            self::TYPE_ACTUAL => 'фактический',
            self::TYPE_REGISTRATION => 'постоянный',
            self::TYPE_RESIDENCE => 'временный',
        ];
    }

    public static function rangeAddress()
    {
        return [
            self::TYPE_ACTUAL,
            self::TYPE_REGISTRATION,
            self::TYPE_RESIDENCE,
        ];
    }

    public static function typeName($type): ? string
    {
        return ArrayHelper::getValue(self::typeOfAddress(), $type);
    }


}