<?php


namespace modules\dictionary\helpers;


use modules\dictionary\models\DictCseSubject;
use yii\helpers\ArrayHelper;

class DictCseSubjectHelper
{
    const CSE_STATUS_YES =1;

    public static function subjectCseList() : array
    {
        return ArrayHelper::map(DictCseSubject::find()->where(['cse_status'=> self::CSE_STATUS_YES])
            ->orderBy(['name'=>SORT_ASC])->all(), "id", 'name');
    }

    public static function name($key) : string
    {
        return ArrayHelper::getValue(self::subjectCseList(), $key);
    }

}