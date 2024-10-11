<?php


namespace olympic\helpers;

use olympic\models\OlympicSpeciality;
use olympic\models\OlympicSpecialityOlimpicList;
use olympic\models\OlympicSpecialityProfile;
use yii\helpers\ArrayHelper;

class OlympicSpecialityProfileHelper
{
    public static function allProfilesByOlympic($id) {

        ;
        return ArrayHelper::map(OlympicSpecialityProfile::find()
            ->joinWith('olympicSpeciality')
            ->select(
                OlympicSpeciality::tableName().'.name AS speciality_name, '.
                        OlympicSpecialityProfile::tableName().'.id AS id, '.
                        OlympicSpecialityProfile::tableName().'.name AS profile_name, '
            )
            ->andWhere(['olympic_speciality_id' =>  OlympicSpecialityOlimpicList::allOlympicSpecialityByOlympicList($id)])
            ->asArray()
            ->all(),
            "id", function (array $model) {
                return $model['profile_name'] . ' ('. $model['speciality_name']. ')';
            });
    }
}