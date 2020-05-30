<?php


namespace dictionary\helpers;


use dictionary\models\Faculty;
use yii\helpers\ArrayHelper;

class DictFacultyHelper
{

    const YES_FILIAL = 1;
    const NO_FILIAL = 0;

    const COLLAGE = 19;

    const ANAPA_BRANCH = 21;
    const POKROV_BRANCH = 24;
    const STAVROPOL_BRANCH = 23;
    const DERBENT_BRANCH = 22;
    const SERGIEV_POSAD_BRANCH = 40;

    const NO_FACULTY_ID = [19,20,25,26,27,33,35];


    public static function facultyList(): array
    {
        return ArrayHelper::map(Faculty::find()->all(), "id", 'full_name');
    }

    public static function facultyIncomingList(): array
    {
        return ArrayHelper::map(Faculty::find()->where(['filial' =>false])->andWhere(['not in','id',self::NO_FACULTY_ID])->all(), "id", 'full_name');
    }

    public static function facultyName($id): ?string
    {
        return ArrayHelper::getValue(self::facultyList(), $id);
    }


}