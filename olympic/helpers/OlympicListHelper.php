<?php


namespace olympic\helpers;


use common\helpers\EduYearHelper;
use dictionary\models\Faculty;
use olympic\models\OlimpicList;
use olympic\models\Olympic;
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

    public static function olympicListYear(): array
    {
        return ArrayHelper::map(OlimpicList::find()->select('year')->groupBy('year')->all(),  "year", 'year');
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

    public static function olympicMenu($formEdu, $isFilial) {
        $query = Olympic::find()->alias('o');
        $query->innerJoin(OlimpicList::tableName() . ' ol', 'ol.olimpic_id = o.id');
        $query->innerJoin(Faculty::tableName() . ' fac', 'fac.id = ol.faculty_id');
        $query->select('fac.id');
        $query->where(['o.status' => OlympicHelper::ACTIVE]);
        $query->andWhere(['ol.year' => EduYearHelper::eduYear() ]);
        $query->andWhere(['ol.prefilling' => false]);
        $query->andWhere(['ol.edu_level_olymp' => $formEdu]);
        $query->andWhere(['fac.filial' => $isFilial]);
        $query->groupBy(['ol.faculty_id']);
        $query->orderBy(['fac.full_name'=> SORT_ASC]);
        return $query->all();
    }
}