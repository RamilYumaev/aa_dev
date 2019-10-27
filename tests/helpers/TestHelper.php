<?php

namespace tests\helpers;

use yii\helpers\ArrayHelper;

class TestHelper
{
    const BALL = 1;
    const PERSENT = 2;

    public static function typeCalculateList()
    {
        return [self::BALL => 'проходной балл',
            self::PERSENT => 'процент',];
    }

    public static function typeCalculateName($key): string
    {
        return ArrayHelper::getValue(self::typeCalculateList(), $key);
    }
}