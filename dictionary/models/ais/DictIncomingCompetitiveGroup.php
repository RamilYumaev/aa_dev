<?php

namespace dictionary\models\ais;

use dictionary\interfaces\DictAisInterface;
use dictionary\models\DictCompetitiveGroup;

class DictIncomingCompetitiveGroup extends DictCompetitiveGroup implements DictAisInterface
{
    public function attributeAis(): array
    {
        return [
            'specialty_id' => 'speciality_id',
            'specialization_id'=>'specialization_id',
            'education_level_id'=>'edu_level',
            'education_program_id'=>'education_form_id',
            'financing_type_id' => 'financing_type_id',
            'faculty_id'=> 'faculty_id',
            'kcp'=>'kcp',
            'special_right_id'=> 'special_right_id',
//            'competition_count' =>
////            'passing_score',
////            'link',
////            'is_new_program',
////            'only_pay_status',
            'education_duration'=> 'education_duration',
           // 'year',
        ];
    }

    public function dataAis(array $data):array
    {
        $array = [];
        foreach (array_intersect_key($data,$this->attributeAis()) as $key => $value) {
            $array[$this->attributeAis()[$key]]  = $value;
        }
        return  $array;

    }
}