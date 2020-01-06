<?php


namespace olympic\helpers;


use common\helpers\EduYearHelper;
use olympic\models\OlimpicList;
use yii\helpers\ArrayHelper;

class OlympicListHelper
{


    public static function olympicList(): array
    {
        return ArrayHelper::map(OlimpicList::find()->all(), "id", 'name');
    }

    public static function olympicName($key): string
    {
        return ArrayHelper::getValue(self::olympicList(), $key);
    }

    public static function timeDistanceTour(): array
    {
        return ArrayHelper::map(OlimpicList::find()->all(), "id", 'time_of_distants_tour');
    }

    public static function timeDistanceTourData($key): ?string
    {
        return ArrayHelper::getValue(self::timeDistanceTour(), $key);
    }

    public static function olympicListEduYear(): array
    {
        return ArrayHelper::map(OlimpicList::find()->where(['year'=> EduYearHelper::eduYear() ])->all(), "id", 'name');
    }

    public static function olympicOne($id): OlimpicList
    {
        return OlimpicList::findOne($id);
    }


    public static function olympicAndYearList(): array
    {
        return ArrayHelper::map(OlimpicList::find()->asArray()->all(), "id", function (array $model) {
           return  $model['name'] ." (".$model['year'].")";
        });
    }

    public static function olympicNameEduYear($key): string
    {
        return ArrayHelper::getValue(self::olympicListEduYear(), $key);
    }

    public static function olympicAndYearName($key): string
    {
        return ArrayHelper::getValue(self::olympicAndYearList(), $key);
    }
}