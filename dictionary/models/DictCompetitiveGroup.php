<?php


namespace dictionary\models;


use dictionary\forms\DictCompetitiveGroupCreateForm;
use dictionary\forms\DictCompetitiveGroupEditForm;
use dictionary\models\queries\DictCompetitiveGroupQuery;
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


    public static function create(DictCompetitiveGroupCreateForm $form, $faculty_id, $speciality_id, $specialization_id)
    {
        $competitiveGroup = new static();
        $competitiveGroup->speciality_id = $speciality_id;
        $competitiveGroup->specialization_id = $specialization_id;
        $competitiveGroup->edu_level = $form->edu_level;
        $competitiveGroup->education_form_id = $form->education_form_id;
        $competitiveGroup->financing_type_id = $form->financing_type_id;
        $competitiveGroup->faculty_id = $faculty_id;
        $competitiveGroup->kcp = $form->kcp;
        $competitiveGroup->special_right_id = $form->special_right_id;
        $competitiveGroup->passing_score = $form->passing_score;
        $competitiveGroup->is_new_program = $form->is_new_program;
        $competitiveGroup->only_pay_status = $form->only_pay_status;
        $competitiveGroup->competition_count = $form->competition_count;
        $competitiveGroup->education_duration = $form->education_duration;
        $competitiveGroup->link = $form->link;
        return $competitiveGroup;
    }

    public function edit(DictCompetitiveGroupEditForm $form, $faculty_id, $speciality_id, $specialization_id)
    {
        $this->speciality_id = $speciality_id;
        $this->specialization_id = $specialization_id;
        $this->edu_level = $form->edu_level;
        $this->education_form_id = $form->education_form_id;
        $this->financing_type_id = $form->financing_type_id;
        $this->faculty_id = $faculty_id;
        $this->kcp = $form->kcp;
        $this->special_right_id = $form->special_right_id;
        $this->passing_score = $form->passing_score;
        $this->is_new_program = $form->is_new_program;
        $this->only_pay_status = $form->only_pay_status;
        $this->competition_count = $form->competition_count;
        $this->education_duration = $form->education_duration;
        $this->link = $form->link;
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

    public static function find(): DictCompetitiveGroupQuery
    {
        return new DictCompetitiveGroupQuery(static::class);
    }
}