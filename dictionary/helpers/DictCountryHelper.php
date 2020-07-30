<?php


namespace dictionary\helpers;


use dictionary\models\Country;
use yii\db\Expression;
use yii\grid\Column;
use yii\helpers\ArrayHelper;

class DictCountryHelper
{
    const RUSSIA = 46;
    const BELARUS = 49;
    const KYRGYZSTAN = 35;
    const KAZAKHSTAN = 29;
    const TAJIKISTAN = 30;

    const TASHKENT_AGREEMENT = [
        self::BELARUS,
        self::KYRGYZSTAN,
        self::KAZAKHSTAN,
        self::TAJIKISTAN,
    ];


    public static function countryList(): array
    {
        return Country::find()->select(['name', 'cis', 'id'])->orderBy("cis DESC,name ASC")->indexBy("id")->column();
    }

    public static function countryListMap(): array
    {
        return ArrayHelper::map(Country::find()->select(['name', 'cis', 'id'])->orderBy("cis DESC,name ASC")->all(), 'id', 'name');
    }


    public static function countryName($key): ?string
    {
        if(!is_float($key)) {
            return ArrayHelper::getValue(self::countryList(), $key);
        }
        return  null;
    }
}