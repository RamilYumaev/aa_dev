<?php


namespace dictionary\helpers;


use dictionary\models\Country;
use yii\db\Expression;
use yii\grid\Column;
use yii\helpers\ArrayHelper;

class DictCountryHelper
{
    const RUSSIA = 46;

    public static function countryList(): array
    {
        return Country::find()->select(['name', 'cis','id'])->orderBy("cis DESC,name ASC")->indexBy("id")->column();
    }

    public static function countryName($key): ?string
    {
        return ArrayHelper::getValue(self::countryList(), $key);
    }
}