<?php


namespace dictionary\helpers;

use dictionary\models\DictSpeciality;
use yii\helpers\ArrayHelper;

class DictSpecialityHelper
{
    public static function specialityCodeList(): array
    {
        return ArrayHelper::map(DictSpeciality::find()->all(), "id", 'code');
    }

    public static function specialityCodeName($id): ?string
    {
        return ArrayHelper::getValue(self::specialityCodeList(), $id);
    }

    public static function specialityNameAndCodeList(): array
    {
        return ArrayHelper::map(DictSpeciality::find()->asArray()->all(), "id", function (array $model) {
            return $model['code'] . " - " . $model['name'];
        });
    }

    public static function specialityNameAndCode($id): ?string
    {
        return ArrayHelper::getValue(self::specialityNameAndCodeList(), $id);
    }

}