<?php


namespace testing\helpers;


use olympic\helpers\OlympicHelper;
use testing\models\TestQuestion;
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

    /**
     * @param $id
     * @return array
     */
    public static function testQuestionGroupOlympicList($id): array
    {
        return ArrayHelper::map(TestQuestionGroup::find()->where(['olimpic_id'=> $id])->asArray()->all(), "id",
            function (array $model) {
            return $model['name']." (".$model['year'] .")";
        });
    }

    public static function testQuestionGroupOlympicInTestAndQuestionsList($id): array
    {
        $find = TestQuestionGroup::find()->alias('tqg')
            ->select(["tq.group_id",'tqg.name', 'tqg.year', 'tqg.id',
                'countQue' =>"COUNT(tq.group_id)"
            ])->innerJoin(TestQuestion::tableName() .' tq','tqg.id=tq.group_id')
            ->andwhere(['tqg.olimpic_id'=> $id])->groupBy('tq.group_id')->having(['>=','countQue', 2])->asArray()->all();

        return ArrayHelper::map($find, "id",
            function (array $model) {
                return $model['name']." (".$model['year'] .")".  "(".$model['countQue'] .")";
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