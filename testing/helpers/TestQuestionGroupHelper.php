<?php


namespace tests\helpers;


use tests\models\TestQuestionGroup;
use yii\helpers\ArrayHelper;

class TestQuestionGroupHelper
{
    public static function testQuestionGroupList(): array
    {
        return ArrayHelper::map(TestQuestionGroup::find()->all(), "id", 'name');
    }

    public static function testQuestionGroupName($key): string
    {
        return ArrayHelper::getValue(self::testQuestionGroupList(), $key);
    }

}