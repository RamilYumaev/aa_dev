<?php


namespace dictionary\forms;


use common\helpers\EduYearHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use dictionary\helpers\DictSpecializationHelper;
use dictionary\models\DictCompetitiveGroup;
use yii\base\Model;

class DictCompetitiveGroupCreateForm extends Model
{

    public $id, $speciality_id, $specialization_id, $education_form_id, $financing_type_id, $faculty_id,
        $kcp, $special_right_id, $passing_score, $is_new_program, $only_pay_status, $competition_count, $education_duration,
        $link, $year, $education_year_cost,  $cathedraList, $enquiry_086_u_status, $spo_class, $discount, $ais_id,
        $foreigner_status, $only_spo, $edu_level, $tpgu_status, $additional_set_status;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id',
                'kcp', 'year', 'education_duration', 'edu_level'], 'required'],
            [['speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id',
                'kcp', 'special_right_id', 'passing_score', 'is_new_program', 'only_pay_status', 'ais_id', 'spo_class',
                'enquiry_086_u_status', 'foreigner_status', 'edu_level', 'only_spo', 'tpgu_status',
                'additional_set_status'], 'integer'],
            [['competition_count'], 'number'],
            [['education_duration', 'discount', 'education_year_cost'], 'double'],
            [['link'], 'string', 'max' => 255],
            [['year','speciality_id', 'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id',
                'special_right_id'],
                'unique', 'targetClass' => DictCompetitiveGroup::class, 'targetAttribute' => ['speciality_id',
                'specialization_id', 'education_form_id', 'financing_type_id', 'faculty_id', 'special_right_id', 'year'],
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

    public function educationLevelList(): array {
        return DictCompetitiveGroupHelper::getEduLevels();
    }

    public function yearList():array
    {
        return EduYearHelper::eduYearList();
    }
}