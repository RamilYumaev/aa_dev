<?php


namespace dictionary\forms;


use common\helpers\EduYearHelper;
use dictionary\helpers\CathedraCgHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use dictionary\helpers\DictSpecializationHelper;
use dictionary\models\DictCompetitiveGroup;
use yii\base\Model;

class DictCompetitiveGroupEditForm extends Model
{

    public $speciality_id, $specialization_id, $education_form_id, $financing_type_id, $faculty_id,
        $kcp, $special_right_id, $passing_score, $is_new_program, $only_pay_status, $competition_count, $education_duration,
        $link, $year, $education_year_cost,  $cathedraList, $enquiry_086_u_status, $spo_class, $discount, $ais_id,
        $foreigner_status, $edu_level, $only_spo, $_competitiveGroup, $tpgu_status, $additional_set_status;

    public function __construct(DictCompetitiveGroup $competitiveGroup, $config = [])
    {
        $this->cathedraList = CathedraCgHelper::cathedraList($competitiveGroup->id);
        $this->speciality_id = $competitiveGroup->speciality_id;
        $this->specialization_id = $competitiveGroup->specialization_id;
        $this->education_form_id = $competitiveGroup->education_form_id;
        $this->financing_type_id = $competitiveGroup->financing_type_id;
        $this->edu_level = $competitiveGroup->edu_level;
        $this->faculty_id = $competitiveGroup->faculty_id;
        $this->kcp = $competitiveGroup->kcp;
        $this->special_right_id = $competitiveGroup->special_right_id;
        $this->passing_score = $competitiveGroup->passing_score;
        $this->is_new_program = $competitiveGroup->is_new_program;
        $this->only_pay_status = $competitiveGroup->only_pay_status;
        $this->competition_count = $competitiveGroup->competition_count;
        $this->education_duration = $competitiveGroup->education_duration;
        $this->education_year_cost = $competitiveGroup->education_year_cost;
        $this->discount = $competitiveGroup->discount;
        $this->enquiry_086_u_status = $competitiveGroup->enquiry_086_u_status;
        $this->spo_class = $competitiveGroup->spo_class;
        $this->ais_id = $competitiveGroup->ais_id;
        $this->link = $competitiveGroup->link;
        $this->year = $competitiveGroup->year;
        $this->foreigner_status = $competitiveGroup->foreigner_status;
        $this->only_spo = $competitiveGroup->only_spo;
        $this->_competitiveGroup = $competitiveGroup;
        $this->tpgu_status = $competitiveGroup->tpgu_status;
        $this->additional_set_status = $competitiveGroup->additional_set_status;


        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id', 'kcp', 'year', 'education_duration'], 'required'],
            [['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id',
                'kcp', 'special_right_id', 'passing_score', 'is_new_program', 'only_pay_status', 'ais_id', 'spo_class',
                'enquiry_086_u_status', 'foreigner_status', 'edu_level', 'only_spo'], 'integer'],
            [['competition_count'], 'number'],
            [['education_duration', 'discount', 'education_year_cost'], 'double'],
            [['link'], 'string', 'max' => 255],
            [['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id', 'special_right_id'],
                'unique', 'targetClass' => DictCompetitiveGroup::class,  'filter' => ['<>', 'id', $this->_competitiveGroup->id],  'targetAttribute' => ['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id', 'special_right_id'],
                'message' => 'Такое сочетание уже есть'],
            ['special_right_id', 'in', 'range' => DictCompetitiveGroupHelper::specialRight(), 'allowArray' => true],
            ['financing_type_id', 'in', 'range' => DictCompetitiveGroupHelper::financingTypes(), 'allowArray' => true],
            ['year', 'in', 'range' => EduYearHelper::eduYearList(), 'allowArray' => true],
            ['education_form_id', 'in', 'range' => DictCompetitiveGroupHelper::forms(), 'allowArray' => true],
            [['cathedraList'], 'safe'],

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