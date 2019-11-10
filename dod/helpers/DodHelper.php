<?php

namespace dod\helpers;

use dod\models\Dod;
use yii\helpers\ArrayHelper;

class DodHelper
{
    const SHARE_YES = 1;
    const SHARE_NO = 0;

    public static function listStatus(): array
    {
        return [
            self::SHARE_NO => "Нет",
            self::SHARE_YES => "Да"
        ];
    }

    public static function statusName($key): string
    {
        return ArrayHelper::getValue(self::listStatus(), $key);
    }

    public static function dodList(): array
    {
        return ArrayHelper::map(Dod::find()->all(), "id", 'name');
    }

    public static function dodName($key): string
    {
        return ArrayHelper::getValue(self::dodList(), $key);
    }
}