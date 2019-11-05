<?php


namespace olympic\helpers;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictSpecialityHelper;
use dictionary\helpers\DictSpecializationHelper;
use dictionary\models\DictCompetitiveGroup;
use olympic\models\OlimpicCg;


class OlimpicCgHelper
{
    public static function cgOlympicList($id) {
       return OlimpicCg::find()->select('competitive_group_id')->andWhere(['olimpic_id'=> $id])->column();
    }

    public static function cgOlympicCompetitiveGroupList ($id) {
       $competitiveGroup = DictCompetitiveGroup::find()->where(['in', 'id', self::cgOlympicList($id)])->asArray()->all();
       $result = "";
       foreach ($competitiveGroup as $value) {
           $result .=  DictSpecialityHelper::specialityNameAndCode($value['speciality_id']);
           if ($value['edu_level'] == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR) {
               $result .= ', профиль (профили) ';
           } elseif ($value['edu_level'] == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER) {
               $result .= ', магистерская программа ';
           } else {
               $result .= ', образовательная программа ';
           }
           $result .= DictSpecializationHelper::specializationName($value['specialization_id']);
           $result .= ' (' .DictCompetitiveGroupHelper::formName($value['education_form_id']). ' форма обучения)';
           $result .= "; ";
       }
       return rtrim($result, "; ");
    }
}