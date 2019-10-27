<?php


namespace dictionary\models;


use yii\db\ActiveRecord;

class DictCompetitiveGroup extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_competitive_group';
    }


    public static function create($speciality_id, $specialization_id, $edu_level, $education_form_id, $financing_type_id, $faculty_id,
                                  $kcp, $special_right_id, $passing_score, $is_new_program, $only_pay_status, $competition_count, $education_duration,
                                  $link)
    {
        $competitiveGroup = new static();
        $competitiveGroup->speciality_id = $speciality_id;
        $competitiveGroup->specialization_id = $specialization_id;
        $competitiveGroup->edu_level = $edu_level;
        $competitiveGroup->education_form_id = $education_form_id;
        $competitiveGroup->financing_type_id = $financing_type_id;
        $competitiveGroup->faculty_id = $faculty_id;
        $competitiveGroup->kcp = $kcp;
        $competitiveGroup->special_right_id = $special_right_id;
        $competitiveGroup->passing_score = $passing_score;
        $competitiveGroup->is_new_program = $is_new_program;
        $competitiveGroup->only_pay_status = $only_pay_status;
        $competitiveGroup->competition_count = $competition_count;
        $competitiveGroup->education_duration = $education_duration;
        $competitiveGroup->link = $link;
        return $competitiveGroup;
    }

    public function edit($speciality_id, $specialization_id, $edu_level, $education_form_id, $financing_type_id, $faculty_id,
                         $kcp, $special_right_id, $passing_score, $is_new_program, $only_pay_status, $competition_count, $education_duration,
                         $link)
    {
        $this->speciality_id = $speciality_id;
        $this->specialization_id = $specialization_id;
        $this->edu_level = $edu_level;
        $this->education_form_id = $education_form_id;
        $this->financing_type_id = $financing_type_id;
        $this->faculty_id = $faculty_id;
        $this->kcp = $kcp;
        $this->special_right_id = $special_right_id;
        $this->passing_score = $passing_score;
        $this->is_new_program = $is_new_program;
        $this->only_pay_status = $only_pay_status;
        $this->competition_count = $competition_count;
        $this->education_duration = $education_duration;
        $this->link = $link;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'speciality_id' => 'Направление подготовки',
            'specialization_id' => 'Образовательная программа',
            'edu_level' => 'Уровень образования',
            'education_form_id' => 'Форма обучения',
            'financing_type_id' => 'Вид финансирования',
            'faculty_id' => 'Факультет',
            'kcp' => 'КЦП',
            'special_right_id' => 'Квота /целевое',
            'competition_count' => 'Конкурс',
            'passing_score' => 'Проходной балл',
            'link' => 'Ссылка на ООП',
            'is_new_program' => 'Новая программа',
            'only_pay_status' => 'Только на платной основе',
            'education_duration' => 'Срок обучения',
        ];
    }

    public static function labels(): array
    {
        $competitiveGroup = new static();
        return $competitiveGroup->attributeLabels();
    }
}