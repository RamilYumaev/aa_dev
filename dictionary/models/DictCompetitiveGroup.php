<?php


namespace dictionary\models;


use backend\widgets\olimpic\OlipicListInOLymipViewWidget;
use dictionary\forms\DictCompetitiveGroupCreateForm;
use dictionary\forms\DictCompetitiveGroupEditForm;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\queries\DictCompetitiveGroupQuery;
use frontend\controllers\GratitudeController;
use modules\dictionary\models\CompetitionList;
use modules\dictionary\models\DictCseSubject;
use modules\dictionary\models\DictCtSubject;
use modules\dictionary\models\RegisterCompetitionList;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\ConverterBasicExam;
use modules\entrant\helpers\CseSubjectHelper;
use modules\entrant\models\AisOrderTransfer;
use modules\entrant\models\Infoda;
use modules\entrant\models\UserCg;
use Mpdf\Tag\Dt;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

/**
 * Class DictCompetitiveGroup
 * @package dictionary\models
 * @property $special_right_id string
 * @property $success_speciality string
 * @property $is_unavailable_transfer
 */
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
        $competitiveGroup->only_spo = $form->only_spo;
        $competitiveGroup->tpgu_status = $form->tpgu_status;
        $competitiveGroup->additional_set_status = $form->additional_set_status;
        $competitiveGroup->success_speciality = $form->success_speciality ? json_encode($form->success_speciality) : null;
        $competitiveGroup->is_unavailable_transfer = $form->is_unavailable_transfer;


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
        $this->only_spo = $form->only_spo;
        $this->tpgu_status = $form->tpgu_status;
        $this->additional_set_status = $form->additional_set_status;
        $this->success_speciality = $form->success_speciality ? json_encode($form->success_speciality) : null;
        $this->is_unavailable_transfer = $form->is_unavailable_transfer;
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
            'only_spo' => 'Только для абитуриентов из колледжа',
            'tpgu_status'=> 'для ТПГУ',
            'additional_set_status'=> 'Дополнительный набор',
            'fullNameB'=> "Конкурсная группа",
            'success_speciality' => 'Допущенные направления подготовки к участию в конкурсе',
            'is_unavailable_transfer' => 'Недоступен для перевода и восстановления'
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
        return $this->hasMany(DisciplineCompetitiveGroup::class, ['competitive_group_id' => 'id'])->orderBy(['priority' => SORT_ASC]);
    }

    public function getExaminationsAisId()
    {
        $array = [];
        foreach ($this->getExaminations()->with(['discipline', 'disciplineSpo'])->all() as $examination) {
            $discipline = $examination->discipline;
            $disciplineSpo = $examination->disciplineSpo;
            if($disciplineSpo) {
                foreach (ConverterBasicExam::getCompositeDisciplines() as $key => $compositeDiscipline) {
                    if($compositeDiscipline[0] == $discipline->ais_id && $compositeDiscipline[1] == $disciplineSpo->ais_id) {
                        $array[$key] = $discipline->name."/". $disciplineSpo->name;
                        break;
                    }
                }
            }else {
                $array[$discipline->ais_id] = $discipline->name;
            }
        }
        return $array;
    }

    public function getExaminationsCseAisId()
    {
        return DictDiscipline::find()->joinWith('cse')
            ->select(['f' => DictDiscipline::tableName().'.ais_id'])
            ->indexBy('dict_cse_subject.ais_id')
            ->column();
    }

    public function getExaminationsCtAisId()
    {
        return DictDiscipline::find()->joinWith('ct')
            ->select(['f' => DictDiscipline::tableName().'.ais_id' ])
            ->indexBy('dict_ct_subject.ais_id')
            ->column();
    }

    public function getExaminationsGraduateAisId()
    {
        $column = $this->getExaminations()
            ->joinWith('discipline')
            ->select(['name', 'ais_id'])
            ->andWhere(['not', ['ais_id'=> null]])
            ->andWhere(['not like','name','Специальная дисциплина'])
            ->indexBy('ais_id')
            ->column();
        return [0=>'Специальная дисциплина']+ $column;
    }

    public function getCompositeDisciplineId()
    {
        return $this->getExaminations()
            ->joinWith('discipline')
            ->andWhere(['composite_discipline' => true])
            ->select(['dict_discipline.id'])
            ->column();
    }

    public function isExamOch() {
        return $this->getExaminations()->joinWith('discipline')
            ->andWhere(['is_och' => true])->exists();
    }

    public function isExamSpoVy() {
        return $this->getExaminations()
            ->andWhere(['not', ['spo_discipline_id' => null]])->exists();
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
        /** @var DictCompetitiveGroup $cgBudget */
        $cgBudget = self::find()->findBudgetAnalog($cgContract)->one();

        if ($cgBudget &&
            $anketa->category_id !== CategoryStruct::FOREIGNER_CONTRACT_COMPETITION &&
            SettingEntrant::find()->isOpenZUK($cgBudget)
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
            case 4 :
                return DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER;
            case 5 :
                return DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO;
            case 6 :
                return DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;
            case 7 :
                return DictCompetitiveGroupHelper::EDUCATION_LEVEL_BVO;
            case 8 :
                return DictCompetitiveGroupHelper::EDUCATION_LEVEL_SVO;
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
            2021 => "2020-2021",
            2020 => "2019-2020",
            2019 => "2018-2019",
            2018 => "2017-2018",
        ];
    }

    public function yearConverter() {
        return explode('-', $this->year);
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
    {
        $edu_level = DictCompetitiveGroupHelper::eduLevelAbbreviatedName($this->edu_level);
        $form_edu = DictCompetitiveGroupHelper::formName($this->education_form_id);
        $budget = DictCompetitiveGroupHelper::financingTypeName(DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET);
        return $this->specialty->codeWithName . ' ' . ($this->specialization->name ?? "") . " / " . $edu_level
            . " / " . StringHelper::mb_ucfirst($form_edu)
            . " / " . $budget;
    }

    public function getFullNameB()
    {
        $edu_level = DictCompetitiveGroupHelper::eduLevelAbbreviatedName($this->edu_level);
        $form_edu = DictCompetitiveGroupHelper::formName($this->education_form_id);
        $budget = DictCompetitiveGroupHelper::financingTypeName($this->financing_type_id);
        $specialRight = DictCompetitiveGroupHelper::specialRightName($this->special_right_id);
        return $this->specialty->codeWithName . ' ' . ($this->specialization->name ?? "") . " / " . $edu_level
            . " / " . StringHelper::mb_ucfirst($form_edu)
            . " / " . $budget
            . " / " . $specialRight;
    }

    public function getFullNameTransfer()
    {
        $edu_level = DictCompetitiveGroupHelper::eduLevelAbbreviatedName($this->edu_level);
        $form_edu = DictCompetitiveGroupHelper::formName($this->education_form_id);
        $budget = DictCompetitiveGroupHelper::financingTypeName($this->financing_type_id);
        $specialRight = DictCompetitiveGroupHelper::specialRightName($this->special_right_id);
        return $this->specialty->codeWithName . ' ' . ($this->specialization->name ?? "") . " / " . $edu_level
            . " / " . StringHelper::mb_ucfirst($form_edu)
            . " / " . $budget
            . " / " . $specialRight;
    }


    public function getFullNameOlympic()
    {
        $edu_level = DictCompetitiveGroupHelper::eduLevelAbbreviatedName($this->edu_level);
        $form_edu = DictCompetitiveGroupHelper::formName($this->education_form_id);
        $budget = DictCompetitiveGroupHelper::financingTypeName($this->financing_type_id);
        $specialRight = DictCompetitiveGroupHelper::specialRightName($this->special_right_id);
        return $this->year . " / " . $this->faculty->full_name . " / " . $this->specialty->codeWithName .
            ' / ' . ($this->specialization->name ?? "") . " / " . $edu_level
            . " / " . StringHelper::mb_ucfirst($form_edu)
            . " / " . $budget
            . " / " . $specialRight;
    }

    public function getEduLevel() {
        return DictCompetitiveGroupHelper::getEduLevelsAbbreviated()[$this->edu_level];
    }

    public function getEduLevelFull() {
        return DictCompetitiveGroupHelper::getEduLevels()[$this->edu_level];
    }

    public function getRegisterCompetition() {
        return $this->hasOne(RegisterCompetitionList::class,['ais_cg_id' => 'ais_id'])->joinWith('competitionList')
            ->andWhere(['status'=> RegisterCompetitionList::STATUS_SUCCESS]);
    }

    public function getRegisterCompetitionList($type) {
        return $this->getRegisterCompetition()->andWhere(['type'=> $type])->exists();

    }
    public function getRegisterCompetitionListGraduate($faculty, $speciality, $form)
    {
        return RegisterCompetitionList::find()
            ->joinWith(['competitionList', 'settingEntrant'])
            ->andWhere([
                'status'=> RegisterCompetitionList::STATUS_SUCCESS,
                'special_right' =>  $this->special_right_id,
                'edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL,
                'form_edu' => $form,
                 RegisterCompetitionList::tableName().'.faculty_id' => $faculty,
                'speciality_id' => $speciality,
                'finance_edu' => $this->financing_type_id,
            ])->one();
    }

        public function getFinance() {
        return DictCompetitiveGroupHelper::getFinancingTypes()[$this->financing_type_id];
    }

    public function getSpecialRight() {
        return DictCompetitiveGroupHelper::getSpecialRight()[$this->special_right_id];
    }

    public function getFormEdu() {
        return  DictCompetitiveGroupHelper::getEduForms()[$this->education_form_id];
    }

    public function getSpecialisationName() {
       return $this->specialization  ? $this->specialization->name : "";
    }

    public function isGovLineCg(): bool
    {
        return $this->financing_type_id == DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET && $this->foreigner_status;
    }

    public function isContractCg(): bool
    {
        return $this->financing_type_id == DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT;
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

    public function isKvota()
    {
        return $this->special_right_id == DictCompetitiveGroupHelper::SPECIAL_RIGHT;
    }

    public function isSpecQuota()
    {
        return $this->special_right_id == DictCompetitiveGroupHelper::SPECIAL_QUOTA;
    }

    public function isTarget()
    {
        return $this->special_right_id == DictCompetitiveGroupHelper::TARGET_PLACE;
    }

    public function isMagistracy()
    {
        return $this->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER;
    }

    public function isBachelor()
    {
        return $this->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR;

    }

    public function isHighGraduate()
    {
        return $this->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;
    }

    public function isSpo()
    {
        return $this->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO;
    }

    public function isHighGraduateOrSpo()
    {
        return $this->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL ||
            $this->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO;
    }

    public function isBachelorOrSpoFilial()
    {
        return ($this->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR ||
            $this->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO)  && in_array($this->faculty_id, DictFacultyHelper::FACULTY_FILIAL);
    }

    public function getAisOrderTransfer(){
        return $this->hasMany(AisOrderTransfer::class, ['ais_cg' =>'ais_id']);
    }
}