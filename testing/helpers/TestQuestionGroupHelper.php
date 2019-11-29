<?php


namespace testing\helpers;


use olympic\helpers\OlympicHelper;
use testing\models\TestQuestionGroup;
use yii\helpers\ArrayHelper;

class TestQuestionGroupHelper
{
    public static function testQuestionGroupList(): array
    {
        return ArrayHelper::map(TestQuestionGroup::find()->asArray()->all(), "id", function (array $model) {
            return $model['name']." (".$model['year'] .")";
        });
    }

    public static function testQuestionGroupOlympicList($id): array
    {
        return ArrayHelper::map(TestQuestionGroup::find()->where(['olimpic_id' => $id])->asArray()->all(), "id", function (array $model) {
            return $model['name']." (".$model['year'] .")";
        });
    }

    public static function testQuestionGroupName($key): ?string
    {
        return ArrayHelper::getValue(self::testQuestionGroupList(), $key);
    }

    public static function testQuestionGroupYearList(): array
    {
        return ArrayHelper::map(TestQuestionGroup::find()->indexBy(['year'])->all(), "year", 'year');
    }

    public static function testQuestionGroupOlympicNameList(): array
    {
        return ArrayHelper::map(TestQuestionGroup::find()->indexBy(['olimpic_id'])->asArray()->all(), "olimpic_id",
            function (array $model) {
                return  OlympicHelper::olympicName($model['olimpic_id']);
            });
    }

}