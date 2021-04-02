<?php


namespace dictionary\helpers;


use dictionary\models\Faculty;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\models\Anketa;
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

    const FACULTY_FILIAL = [self::ANAPA_BRANCH, self::POKROV_BRANCH, self::STAVROPOL_BRANCH,
        self::SERGIEV_POSAD_BRANCH, self::DERBENT_BRANCH];

    const FACULTY_NO_IN_UNI = [self::ANAPA_BRANCH, self::POKROV_BRANCH, self::STAVROPOL_BRANCH,
        self::SERGIEV_POSAD_BRANCH, self::DERBENT_BRANCH, self::COLLAGE];

    public static function facultyList(): array
    {
        return Faculty::find()->select(['full_name','id'])->indexBy('id')->column();
    }

    public static function facultyIncomingList(): array
    {
        return ArrayHelper::map(Faculty::find()->where(['filial' =>false])->andWhere(['not in','id',self::NO_FACULTY_ID])->all(), "id", 'full_name');
    }

    public static function facultyName($id): ?string
    {
        return ArrayHelper::getValue(self::facultyList(), $id);
    }

    public static function facultyListSetting(): array
    {
        return [AnketaHelper::HEAD_UNIVERSITY => "В головной вуз МПГУ"] +
            Faculty::find()->andWhere(['id'=> self::FACULTY_FILIAL])
                ->orWhere(['id'=> self::COLLAGE])->indexBy('id')
                ->select('full_name')->column();
    }

    public static function getKeyFacultySetting($faculty_id) {
        return key_exists($faculty_id, self::facultyListSetting()) ?
            $faculty_id : AnketaHelper::HEAD_UNIVERSITY;
    }
}