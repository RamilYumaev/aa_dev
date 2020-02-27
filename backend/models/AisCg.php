<?php


namespace backend\models;

use yii\db\ActiveRecord;

class AisCg extends ActiveRecord
{

    public static function tableName()
    {
        return "ais_cg";
    }

    public static function findCg($facultyId, $specialtyId, $specializationId, $educationFormId, $financingTypeId)
    {
        $cg = self::find()
            ->andWhere(['faculty_id'=> $facultyId])
            ->andWhere(['specialty_id'=>$specialtyId])
            ->andWhere(['specialization_id'=>$specializationId])
            ->andWhere(['education_form_id'=>$educationFormId])
            ->andWhere(['financing_type_id'=>$financingTypeId])
            ->one();
        if(!$cg)
        {
            throw new \DomainException("Конкурсная группа АИС не найдена");
        }
        return $cg;
    }
}