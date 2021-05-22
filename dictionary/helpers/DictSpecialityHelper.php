<?php


namespace dictionary\helpers;

use dictionary\models\DictSpeciality;
use yii\db\Expression;
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

    public static function specialityNameList(): array
    {
        return ArrayHelper::map(DictSpeciality::find()->all(), "id", 'name');
    }

    public static function specialityName($id): ?string
    {
        return ArrayHelper::getValue(self::specialityNameList(), $id);
    }


    public static function specialityNameAndCodeList(): array
    {
        return DictSpeciality::find()->select(new Expression("concat_ws(' - ', code, name)"))->indexBy('id')->column();
    }


    public static function specialityNameAndCodeEduLevelList(): array
    {
        $model = DictSpeciality::find()->indexBy('id')->all();
        $array = [];
        foreach ($model as $key => $value)
        {
            $array[$key] = $value->code." ". $value->name. ' /'. DictCompetitiveGroupHelper::getEduLevelsAbbreviated()[$value->edu_level];
        }

        return  $array;
    }


    public static function specialityNameAndCode($id): ?string
    {
        return ArrayHelper::getValue(self::specialityNameAndCodeList(), $id);
    }

}