<?php


namespace dictionary\helpers;


use dictionary\models\Region;
use yii\helpers\ArrayHelper;

class DictRegionHelper
{
    public static function regionList(): array
    {
        return Region::find()->select(['name', 'id'])->orderBy("name ASC")->indexBy("id")->column();
    }

    public static function regionName($key): ?string
    {
        return ArrayHelper::getValue(self::regionList(), $key);
    }
}