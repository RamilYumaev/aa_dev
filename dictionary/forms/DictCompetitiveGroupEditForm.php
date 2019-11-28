<?php


namespace dictionary\forms;


use common\helpers\EduYearHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use dictionary\helpers\DictSpecializationHelper;
use dictionary\models\DictCompetitiveGroup;
use yii\base\Model;

class DictCompetitiveGroupEditForm extends Model
{

    public $speciality_id, $specialization_id, $edu_level, $education_form_id, $financing_type_id, $faculty_id,
        $kcp, $special_right_id, $passing_score, $is_new_program, $only_pay_status, $competition_count, $education_duration,
        $link, $_competitiveGroup, $year;

    public function __construct(DictCompetitiveGroup $competitiveGroup, $config = [])
    {

        $this->speciality_id = $competitiveGroup->speciality_id;
        $this->specialization_id = $competitiveGroup->specialization_id;
        $this->edu_level = $competitiveGroup->edu_level;
        $this->education_form_id = $competitiveGroup->education_form_id;
        $this->financing_type_id = $competitiveGroup->financing_type_id;
        $this->faculty_id = $competitiveGroup->faculty_id;
        $this->kcp = $competitiveGroup->kcp;
        $this->special_right_id = $competitiveGroup->special_right_id;
        $this->passing_score = $competitiveGroup->passing_score;
        $this->is_new_program = $competitiveGroup->is_new_program;
        $this->only_pay_status = $competitiveGroup->only_pay_status;
        $this->competition_count = $competitiveGroup->competition_count;
        $this->education_duration = $competitiveGroup->education_duration;
        $this->link = $competitiveGroup->link;
        $this->year = $competitiveGroup->year;
        $this->_competitiveGroup= $competitiveGroup;

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speciality_id', 'specialization_id', 'edu_level', 'education_form_id', 'financing_type_id', 'faculty_id', 'kcp', 'year', 'education_duration'], 'required'],
            [['speciality_id', 'specialization_id', 'edu_level', 'education_form_id', 'financing_type_id', 'faculty_id', 'kcp', 'special_right_id', 'passing_score', 'is_new_program', 'only_pay_status'], 'integer'],
            [['competition_count'], 'number'],
            [['education_duration'], 'double'],
            [['link'], 'string', 'max' => 255],
            [['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id', 'special_right_id'],
                'unique', 'targetClass' => DictCompetitiveGroup::class,  'filter' => ['<>', 'id', $this->_competitiveGroup->id],  'targetAttribute' => ['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id', 'special_right_id'],
                'message' => 'Такое сочетание уже есть'],
            ['special_right_id', 'in', 'range' => DictCompetitiveGroupHelper::specialRight(), 'allowArray' => true],
            ['financing_type_id', 'in', 'range' => DictCompetitiveGroupHelper::financingTypes(), 'allowArray' => true],
            ['year', 'in', 'range' => EduYearHelper::eduYearList(), 'allowArray' => true],
            ['edu_level', 'in', 'range' => DictCompetitiveGroupHelper::eduLevels(), 'allowArray' => true],
            ['education_form_id', 'in', 'range' => DictCompetitiveGroupHelper::forms(), 'allowArray' => true],

        ];
    }

    public function attributeLabels(): array
    {
        return DictCompetitiveGroup::labels();
    }

    public function formList(): array
    {
        return DictCompetitiveGroupHelper::getEduForms();
    }

    public function financingTypesList(): array
    {
        return DictCompetitiveGroupHelper::getFinancingTypes();
    }

    public function eduLevelsList(): array
    {
        return DictCompetitiveGroupHelper::getEduLevels();
    }


    public function specialRightList(): array
    {
        return DictCompetitiveGroupHelper::getSpecialRight();
    }

    public function facultyList(): array
    {
        return DictFacultyHelper::facultyList();
    }

    public function specializationList(): array
    {
        return DictSpecializationHelper::specializationList();
    }

    public function specialityNameAndCodeList(): array
    {
        return DictSpecialityHelper::specialityNameAndCodeList();
    }

    public function yearList():array
    {
        return EduYearHelper::eduYearList();
    }
}