<?php
namespace dod\helpers;

use dod\models\Dod;
use yii\helpers\ArrayHelper;

class DodHelper
{
    public static function dodList(): array
    {
        return ArrayHelper::map(Dod::find()->all(), "id", 'name');
    }

    public static function dodName($key): string
    {
        return ArrayHelper::getValue(self::dodList(), $key);
    }
}