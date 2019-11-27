<?php
namespace dictionary\helpers;


use dictionary\models\DictChairmans;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class DictChairmansHelper
{
    public static function chairmansFullNameList(): array
    {
        return ArrayHelper::map(DictChairmans::find()->orderBy(['last_name'=> SORT_ASC])->asArray()->all(), "id", function (array $model) {
            return $model['last_name'] . " " . $model['first_name'] . " " . $model['patronymic'];
        });
    }

    public static function chairmansFullNameOne($key): ? string
    {
        return ArrayHelper::getValue(self::chairmansFullNameList(), $key);
    }

    public static function chairmansNameList(): array
    {
        return ArrayHelper::map(DictChairmans::find()->orderBy(['last_name'=> SORT_ASC])->asArray()->all(), "id", function (array $model) {
            return   $model['last_name'] . " 
            " .StringHelper::truncate($model['first_name'], 1, ".")."
            " .StringHelper::truncate($model['patronymic'], 1, ".");
        });
    }

    public static function chairmansNameOne($key): ? string
    {
        return ArrayHelper::getValue(self::chairmansNameList(), $key);
    }


}