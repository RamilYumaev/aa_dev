<?php


namespace dictionary\helpers;


use dictionary\models\Region;
use yii\helpers\ArrayHelper;

class DictRegionHelper
{
    public static function regionList(): array
    {
        return ArrayHelper::map(Region::find()->orderBy(["name"=> SORT_ASC])->all(), "id", 'name');
    }

    public static function regionName($key): ?string
    {
        return ArrayHelper::getValue(self::regionList(), $key);
    }
}