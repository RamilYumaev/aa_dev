<?php


namespace modules\dictionary\helpers;


use modules\dictionary\models\DictCseSubject;
use yii\helpers\ArrayHelper;

class DictCseSubjectHelper
{
    const MAX = 100;

    const LANGUAGE = 21;
    const BALL_SPO_ID = 99;

    const CSE_STATUS_YES =1;

    private static function modelAll() {
       return DictCseSubject::find()->where(['cse_status'=> self::CSE_STATUS_YES])
            ->orderBy(['name'=>SORT_ASC])->all();
    }

    public static function subjectCseList() : array
    {
        return ArrayHelper::map(self::modelAll(), "id", 'name');
    }

    public static function name($key) : ?string
    {
        return ArrayHelper::getValue(self::subjectCseList(), $key);
    }

    public static function subjectCseMinMarkList() : array
    {
        return ArrayHelper::map(self::modelAll(), "id", 'min_mark');
    }

    public static function valueMark($key) : ?int
    {
        return ArrayHelper::getValue(self::subjectCseMinMarkList(), $key);
    }


    public static function foreignLanguagesIdArray()
    {
            return DictCseSubject::find()->select("id")
                ->andWhere(['or',
                    ['like','name', 'Иностранный'],
                    ['like','name', 'иностранный'],
                    ['like','name', 'иностраный'],
                ])->column();
    }


    public static function listLanguage()
    {
        return ArrayHelper::map(DictCseSubject::find()->where(['or',
            ['like','name', 'Иностранный'],
            ['like','name', 'иностранный'],
            ['like','name', 'иностраный'],
        ])->all(), 'id','name');
    }

    public static function aisId($id)
    {
        $model = DictCseSubject::findOne($id);
        return $model ? $model->ais_id : null;
    }

}