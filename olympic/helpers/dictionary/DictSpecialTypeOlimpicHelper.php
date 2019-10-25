<?php


namespace olympic\helpers\dictionary;


use olympic\models\dictionary\DictSpecialTypeOlimpic;
use yii\helpers\ArrayHelper;

class DictSpecialTypeOlimpicHelper
{
    public static function specialTypeOlimpicList(): array
    {
        return ArrayHelper::map(DictSpecialTypeOlimpic::find()->all(), "id", 'name');
    }

    public static function specialTypeOlimpicName($key): string
    {
        return ArrayHelper::getValue(self::specialTypeOlimpicList(), $key);
    }

}