<?php


namespace olympic\helpers\dictionary;


use olympic\models\dictionary\DictSpecialization;
use yii\helpers\ArrayHelper;

class DictSpecializationHelper
{
    public static function specializationList(): array
    {
        return ArrayHelper::map(DictSpecialization::find()->all(), "id", 'name');
    }

    public static function specializationName($id): string
    {
        return ArrayHelper::getValue(self::specializationList(), $id);
    }

}