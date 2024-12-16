<?php


namespace backend\models;

use yii\db\ActiveRecord;

class AisCg extends ActiveRecord
{

    public static function tableName()
    {
        return date('Y')."_dict_incoming_competitive_group";
    }

    public static function findCg($facultyId, $specialtyId, $specializationId, $educationFormId, $financingTypeId, $year)
    {
        $cg = self::find()
            ->andWhere(['faculty_id' => $facultyId])
            ->andWhere(['specialty_id' => $specialtyId])
            ->andWhere(['in', 'specialization_id', $specializationId])
            ->andWhere(['education_form_id' => $educationFormId])
            ->andWhere(['financing_type_id' => $financingTypeId])
            ->andWhere(['year' => $year])
            ->one();
        return $cg;
    }

    public static function transformEducationForm($educationForm)
    {
        if ($educationForm == 1) {
            return 1;
        } elseif ($educationForm == 2) {
            return 3;
        } elseif ($educationForm == 3) {
            return 2;
        } else {
            throw new \DomainException("Ошибка");
        }
    }
}