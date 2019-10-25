<?php


namespace olympic\helpers\dictionary;


use olympic\models\dictionary\Faculty;
use yii\helpers\ArrayHelper;

class DictFacultyHelper
{
    public static function facultyList(): array
    {
        return ArrayHelper::map(Faculty::find()->all(), "id", 'full_name');
    }

    public static function facultyName($id): string
    {
        return ArrayHelper::getValue(self::facultyList(), $id);
    }

}