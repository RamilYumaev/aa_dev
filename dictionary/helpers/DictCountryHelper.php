<?php


namespace dictionary\helpers;


use dictionary\models\Country;
use yii\db\Expression;
use yii\grid\Column;
use yii\helpers\ArrayHelper;

class DictCountryHelper
{
    public static function countryList(): array
    {
        return Country::find()->select(new Expression("name"))->orderBy(["name" => SORT_ASC])->indexBy("id")->column();
    }

    public static function countryName($key): string
    {
        return ArrayHelper::getValue(self::countryList(), $key);
    }
}