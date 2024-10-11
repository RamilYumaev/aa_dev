<?php

namespace testing\helpers;

use testing\models\Test;
use testing\models\TestClass;
use yii\helpers\ArrayHelper;
use olympic\helpers\OlympicListHelper;

class TestHelper
{
    const BALL = 1;
    const PERSENT = 2;

    const ACTIVE = 1;
    const DRAFT = 0;


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



    public static function testOlympicNameList(): array
    {
        return ArrayHelper::map(Test::find()->indexBy(['olimpic_id'])->asArray()->all(), "olimpic_id",
            function (array $model) {
                return  OlympicListHelper::olympicName($model['olimpic_id']);
            });
    }

    public static function testAndClassActiveOlympicList($olympic_id, $class, $profile = null)
    {
        $find = TestClass::find()->alias('tc')->innerJoin(Test::tableName() .' t','t.id=tc.test_id')
            ->where(['tc.class_id'=> $class])
            ->andwhere(['t.olimpic_id'=> $olympic_id, 't.status' => self::ACTIVE, 'olympic_profile_id' => $profile])->one();
        return $find->test_id ?? null;
    }

    public static function testActiveOlympicList($olympic_id): ?Test
    {
        return Test::find()
            ->andwhere(['olimpic_id'=> $olympic_id, 'status' => self::ACTIVE])->one();
    }

}