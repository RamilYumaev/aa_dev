<?php


namespace dictionary\models;


use backend\widgets\olimpic\OlipicListInOLymipViewWidget;
use dictionary\forms\DictCompetitiveGroupCreateForm;
use dictionary\forms\DictCompetitiveGroupEditForm;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\queries\DictCompetitiveGroupQuery;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\CseSubjectHelper;
use modules\entrant\models\UserCg;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

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
        $competitiveGroup->education_form_id = $form->education_form_id;
        $competitiveGroup->financing_type_id = $form->financing_type_id;
        $competitiveGroup->edu_level = $form->edu_level;
        $competitiveGroup->faculty_id = $faculty_id;
        $competitiveGroup->kcp = $form->kcp;
        $competitiveGroup->special_right_id = $form->special_right_id;
        $competitiveGroup->passing_score = $form->passing_score;
        $competitiveGroup->is_new_program = $form->is_new_program;
        $competitiveGroup->only_pay_status = $form->only_pay_status;
        $competitiveGroup->competition_count = $form->competition_count;
        $competitiveGroup->education_duration = $form->education_duration;
        $competitiveGroup->education_year_cost = $form->education_year_cost;
        $competitiveGroup->discount = $form->discount;
        $competitiveGroup->enquiry_086_u_status = $form->enquiry_086_u_status;
        $competitiveGroup->spo_class = $form->spo_class;
        $competitiveGroup->ais_id = $form->ais_id;
        $competitiveGroup->link = $form->link;
        $competitiveGroup->year = $form->year;
        $competitiveGroup->foreigner_status = $form->foreigner_status;
        return $competitiveGroup;
    }

    public function edit(DictCompetitiveGroupEditForm $form, $faculty_id, $speciality_id, $specialization_id)
    {
        $this->speciality_id = $speciality_id;
        $this->specialization_id = $specialization_id;
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
        $this->education_year_cost = $form->education_year_cost;
        $this->discount = $form->discount;
        $this->enquiry_086_u_status = $form->enquiry_086_u_status;
        $this->spo_class = $form->spo_class;
        $this->ais_id = $form->ais_id;
        $this->link = $form->link;
        $this->year = $form->year;
        $this->foreigner_status = $form->foreigner_status;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'speciality_id' => 'Направление подготовки',
            'specialization_id' => 'Образовательная программа',
            'education_form_id' => 'Форма обучения',
            'financing_type_id' => 'Вид финансирования',
            'edu_level' => 'Уровень образования',
            'faculty_id' => 'Факультет',
            'kcp' => 'КЦП',
            'special_right_id' => 'Квота /целевое',
            'competition_count' => 'Конкурс',
            'passing_score' => 'Проходной балл',
            'link' => 'Ссылка на ООП',
            'is_new_program' => 'Новая программа',
            'only_pay_status' => 'Только на платной основе',
            'education_duration' => 'Срок обучения',
            'year' => 'Учебный год',
            'education_year_cost' => 'Стоимость обучения за год',
            'discount' => 'Скидка',
            'enquiry_086_u_status' => 'Требуется справка 086-у',
            'spo_class' => 'Класс СПО',
            'ais_id' => 'ID  АИС ВУЗ',
            'foreigner_status' => 'Конкурсная группа УМС',
        ];
    }

    public static function labels(): array
    {
        $competitiveGroup = new static();
        return $competitiveGroup->attributeLabels();
    }

    public function getFaculty()
    {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    public function getExaminations()
    {
        return $this->hasMany(DisciplineCompetitiveGroup::class, ['competitive_group_id' => 'id']);
    }


    public function getUserCg()
    {
        return $this->hasMany(UserCg::class, ['cg_id' => 'id']);
    }


    public
    function getSpecialization()
    {
        return $this->hasOne(DictSpecialization::class, ['id' => 'specialization_id']);
    }

    public
    function getSpecialty()
    {
        return $this->hasOne(DictSpeciality::class, ['id' => 'speciality_id']);
    }

    public
    static function find(): DictCompetitiveGroupQuery
    {
        return new DictCompetitiveGroupQuery(static::class);
    }

    public static function findBudgetAnalog($cgContract): array
    {
        $anketa = \Yii::$app->user->identity->anketa();
        /* @var  $setting \modules\entrant\helpers\Settings */
        $setting = \Yii::$app->user->identity->setting();


        $cgBudget = self::find()->findBudgetAnalog($cgContract)->one();

        if ($cgBudget &&
            $anketa->category_id !== CategoryStruct::FOREIGNER_CONTRACT_COMPETITION &&
            $setting->allowCgCseBudget($cgBudget)
        ) {
            return [
                "status" => 1,
                "cgBudgetId" => $cgBudget->id,
                "cgContractId" => $cgContract->id,
                "kcp" => DictCompetitiveGroupHelper::getAllSumKcp($cgContract),
                "competition_count" => $cgBudget->competition_count,
                "passing_score" => $cgBudget->passing_score,

            ];
        }
        return [
            "status" => 0,
            "cgContractId" => $cgContract->id,
            "kcp" => "прием только на платной основе",
            "competition_count" => null,
            "passing_score" => null,
        ];
    }


    public static function findCg($facultyId, $specialtyId, $specializationId, $educationFormId, $financingTypeId,
                                  $year, $specialtyRight, $foreignerStatus, $spoClass)
    {

        $cg = self::find()
            ->andWhere(['faculty_id' => $facultyId])
            ->andWhere(['speciality_id' => $specialtyId])
            ->andWhere(['specialization_id' => $specializationId])
            ->andWhere(['education_form_id' => $educationFormId])
            ->andWhere(['financing_type_id' => $financingTypeId])
            ->andWhere(['special_right_id' => $specialtyRight])
            ->andWhere(['foreigner_status' => $foreignerStatus])
            ->andWhere(['spo_class' => $spoClass])
            ->andWhere(['year' => $year])->one();
        return $cg;
    }

    public static function aisToSdoEduLevelConverter($key)
    {
        switch ($key) {
            case 1 :
                return DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR;
                break;
            case 4 :
                return DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER;
                break;
            case 5 :
                return DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO;
                break;
            case 6 :
                return DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;
                break;

        }
    }

    public static function aisToSdoEduFormConverter($key)
    {
        switch ($key) {
            case 1 :
                return DictCompetitiveGroupHelper::EDU_FORM_OCH;
                break;
            case 2 :
                return DictCompetitiveGroupHelper::EDU_FORM_ZAOCH;
                break;
            case 3 :
                return DictCompetitiveGroupHelper::EDU_FORM_OCH_ZAOCH;
                break;
        }
    }

    public function getFullNameCg()
    {
        return DictCompetitiveGroupHelper::getFullName(null, $this->edu_level,
            $this->speciality_id,
            $this->specialization_id,
            $this->faculty_id,
            $this->education_form_id,
            $this->financing_type_id,
            $this->special_right_id);
    }


    public static function aisToSdoYearConverter()
    {
        return [
            2020 => "2019-2020",
            2019 => "2018-2019",
            2018 => "2017-2018",
        ];
    }

    public static function aisToSdoConverter($key, $year)
    {
        $model = self::find()->andWhere(['ais_id' => $key])->andWhere(["year" => $year])->one();

        if ($model !== null) {
            return $model->id;
        }
        throw new \DomainException("Не найдена кокнурсная группа " . $key);
    }

    public static function kcpSum($cg): Int
    {
        $kcp = self::shareKcp($cg) + self::targetKcp($cg) + self::specialKcp($cg);
        return $kcp;
    }

    public static function targetKcp(DictCompetitiveGroup $cg)
    {
        $model = DictCompetitiveGroup::find()->findBudgetAnalog($cg)
            ->andWhere(['special_right_id' => DictCompetitiveGroupHelper::TARGET_PLACE])->one();

        if ($model) {
            return $model->kcp;
        }

        return null;
    }

    public static function shareKcp(DictCompetitiveGroup $cg)
    {
        $model = DictCompetitiveGroup::find()->findBudgetAnalog($cg)->one();

        if ($model) {
            return $model->kcp;
        }

        return null;
    }

    public static function specialKcp(DictCompetitiveGroup $cg)
    {
        $model = DictCompetitiveGroup::find()->findBudgetAnalog($cg)
            ->andWhere(['special_right_id' => DictCompetitiveGroupHelper::SPECIAL_RIGHT])->one();

        if ($model) {
            return $model->kcp;
        }

        return null;
    }

    public function getFullName()
    {
        $form_edu = DictCompetitiveGroupHelper::formName($this->education_form_id);
        $budget = DictCompetitiveGroupHelper::financingTypeName($this->financing_type_id);

        return ($this->specialization->name ?? "")
            . " / " . StringHelper::mb_ucfirst($form_edu)
            . " / " . $budget;
    }

    public function getFullNameV()
    {   $edu_level =  DictCompetitiveGroupHelper::eduLevelAbbreviatedName($this->edu_level);
        $form_edu = DictCompetitiveGroupHelper::formName($this->education_form_id);
        $budget = DictCompetitiveGroupHelper::financingTypeName(DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET);
        return $this->specialty->codeWithName.' '.($this->specialization->name ?? "") ." / ".$edu_level
            . " / " . StringHelper::mb_ucfirst($form_edu)
            . " / " . $budget;
    }

    public function getFullNameB()
    {   $edu_level =  DictCompetitiveGroupHelper::eduLevelAbbreviatedName($this->edu_level);
        $form_edu = DictCompetitiveGroupHelper::formName($this->education_form_id);
        $budget = DictCompetitiveGroupHelper::financingTypeName($this->financing_type_id);
        return $this->specialty->codeWithName.' '.($this->specialization->name ?? "") ." / ".$edu_level
            . " / " . StringHelper::mb_ucfirst($form_edu)
            . " / " . $budget;
    }


    public function isGovLineCg(): bool
    {
        return $this->financing_type_id == DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET && $this->foreigner_status;
    }

    public function isUmsContractCg(): bool
    {
        return $this->financing_type_id == DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT && $this->foreigner_status;
    }

    public function isUmsCg(): bool
    {
        return $this->foreigner_status;
    }

    public function isOchCg(): bool
    {
        return $this->education_form_id == DictCompetitiveGroupHelper::EDU_FORM_OCH;
    }

    public function isOchZaOchCg(): bool
    {
        return $this->education_form_id == DictCompetitiveGroupHelper::EDU_FORM_OCH_ZAOCH;
    }

    public function isZaOchCg(): bool
    {
        return $this->education_form_id == DictCompetitiveGroupHelper::EDU_FORM_ZAOCH;
    }

    public function isBudget()
    {
        return $this->financing_type_id == DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET;
    }


}