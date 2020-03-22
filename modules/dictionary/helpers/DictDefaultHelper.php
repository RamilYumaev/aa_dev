<?php


namespace modules\dictionary\helpers;


use yii\helpers\ArrayHelper;

class DictDefaultHelper
{
    const NO = 0;
    const YES = 1;

    public static function nameList() : array
    {
        return [
            self::NO => "Нет",
            self::YES => "Да"
        ];
    }

    public static function name($key) : string
    {
        return ArrayHelper::getValue(self::nameList(), $key);
    }

}