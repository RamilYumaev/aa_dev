<?php

namespace testing\helpers;

use testing\models\Test;
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

    public static function testIdOlympic($olympicId) {
        return Test::find()
            ->select('id')
            ->andWhere(['olimpic_id' => $olympicId])
            ->column();
    }


}