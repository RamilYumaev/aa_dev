<?php

namespace dictionary\models\queries;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\Faculty;
use modules\dictionary\models\CathedraCg;
use modules\dictionary\models\DictCathedra;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\CategoryStruct;

class DictCompetitiveGroupQuery extends \yii\db\ActiveQuery
{
    /**
     * @param  $eduLevel
     * @return $this
     */
    public function eduLevel($eduLevel)
    {
        return $this->andWhere(['edu_level' => $eduLevel]);
    }

    public function onlyTpgu(){
        return $this->andWhere(['tpgu_status'=> true]);
    }

    public function tpgu($status){
        return $this->andWhere(['tpgu_status'=> $status]);
    }

    public function allActualFacultyWithoutBranch($spo = false)
    {
        return $this
            ->select('faculty_id')
            ->withoutBranch()
            ->allowDeadLineEducationForm($spo)
            ->currentAutoYear();
    }

    public function allActualFaculty($eduLevel, $form)
    {
        return $this
            ->eduLevel($eduLevel)
            ->select('faculty_id')
            ->formEdu($form)
            ->indexBy('faculty_id')
            ->currentAutoYear()
            ->column();
    }

    public function allowDeadLineEducationForm($spo)
    {
        if($spo && (\Yii::$app->user->identity->setting())->allowSpoContractMoscow()) {
            return $this->andWhere(['in', 'education_form_id',
                [DictCompetitiveGroupHelper::EDU_FORM_ZAOCH,
                    DictCompetitiveGroupHelper::EDU_FORM_OCH_ZAOCH,
                    DictCompetitiveGroupHelper::EDU_FORM_OCH
                ]]);
        }
        if (!(\Yii::$app->user->identity->setting())->allowBacCseOchContactMoscow()) {
            return $this->andWhere(['education_form_id' => DictCompetitiveGroupHelper::EDU_FORM_ZAOCH]);
        }
        return $this->andWhere(['in', 'education_form_id',
            [DictCompetitiveGroupHelper::EDU_FORM_ZAOCH,
                DictCompetitiveGroupHelper::EDU_FORM_OCH_ZAOCH,
                DictCompetitiveGroupHelper::EDU_FORM_OCH
            ]]);

    }

    public function branch($branchId)
    {
        return $this
            ->select('faculty_id')
            ->andWhere(['faculty_id' => $branchId])
            ->currentAutoYear();
    }

    public function onlyTarget()
    {
        return $this->andWhere(["special_right_id" => DictCompetitiveGroupHelper::TARGET_PLACE]);
    }

    public function onlySpecialRight()
    {
        return $this->andWhere(['special_right_id' => DictCompetitiveGroupHelper::SPECIAL_RIGHT]);
    }

    public function getAllCg($year)
    {
        return $this->andWhere(['year' => $year])->all();
    }

    public function getGovLineCg()
    {
        return $this->budgetOnly()
            ->andWhere(["foreigner_status" => 1]);
    }

    public function faculty($facultyId)
    {
        return $this->andWhere(['faculty_id' => $facultyId]);
    }

    public function notInFaculty()
    {
        return $this->andWhere(['not in', 'faculty_id', DictFacultyHelper::FACULTY_NO_IN_UNI]);
    }

    public function filialAndCollege()
    {
        return $this->andWhere(['in', 'faculty_id', DictFacultyHelper::FACULTY_NO_IN_UNI]);
    }

    public function speciality($specialityId)
    {
        return $this->andWhere(['speciality_id' => $specialityId]);
    }

    public function specialization($specializationId)
    {
        return $this->andWhere(['specialization_id' => $specializationId]);
    }

    public function withoutBranch()
    {
        return $this
            ->andWhere(['not in', 'faculty_id', Faculty::find()
                ->select('id')
                ->andWhere(['filial' => DictFacultyHelper::YES_FILIAL])->column()]);
    }

    public function ForeignerCgSwitch()
    {
        $anketa = $this->getAnketa();
        if ($anketa->category_id == CategoryStruct::FOREIGNER_CONTRACT_COMPETITION ||
            $anketa->category_id == CategoryStruct::GOV_LINE_COMPETITION
        ) {
            return $this->andWhere(['foreigner_status' => 1]);
        }
        return $this->andWhere(['foreigner_status' => 0]);
    }

    public function withoutForeignerCg()
    {
        return $this->andWhere(['foreigner_status' => 0]);
    }

    public function budgetAndContractOnly()
    {
        return $this->andWhere(['or',
            ['financing_type_id' => DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET],
            ['only_pay_status' => true]]);
    }

    public function findBudgetAnalog($cgContract, $specialRight = null)
    {
        $query = $this->andWhere(
            ['financing_type_id' => DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET,
                'faculty_id' => $cgContract->faculty_id,
                'year' => $cgContract->year,
                'speciality_id' => $cgContract->speciality_id,
                'specialization_id' => $cgContract->specialization_id,
                'foreigner_status' => 0,
                'edu_level' => $cgContract->edu_level,
                'education_form_id' => $cgContract->education_form_id,
                'spo_class' => $cgContract->spo_class,

            ]
        );
        if($specialRight) {
            $query->specialRight($specialRight);
        }

        return $query;
    }

    public function cgAllGroup($cgContract, $eduLevel)
    {
        $array1 = ['faculty_id' => $cgContract->faculty_id,
        'education_form_id' => $cgContract->education_form_id,
        'speciality_id' => $cgContract->speciality_id];

        $array2 =[
            'specialization_id' => $cgContract->specialization_id,
            'foreigner_status' => 0,
            'year' => $cgContract->year,
            'edu_level' => $cgContract->edu_level,
            'spo_class' => $cgContract->spo_class,
        ];

        if($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL)
        {
           return $this->andWhere($array1)->select(['financing_type_id', 'special_right_id'])->groupBy(['financing_type_id', 'special_right_id'])->all();
        }

        return $this->andWhere(array_merge($array1, $array2))->all();
    }

    public function foreignerStatus($foreignerStatus)
    {
        return $this->andWhere(['foreigner_status' => $foreignerStatus]);
    }

    public function formEdu($formId)
    {
        return $this->andWhere(['education_form_id' => $formId]);
    }

    public function aisId($aisId)
    {
        return $this->andWhere(['ais_id' => $aisId]);
    }


    public function contractOnly()
    {
        return $this->andWhere(
            ['financing_type_id' => DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT]);
    }

    public function budgetOnly()
    {
        return $this->andWhere(
            ['financing_type_id' => DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET]);
    }

    public function finance($financeId)
    {
        return $this->andWhere(
            ['financing_type_id' => $financeId]);
    }

    public function userCg($user_id)
    {
        return $this->joinWith('userCg')->where(['user_id' => $user_id]);
    }

    public function examinations()
    {
        return $this->joinWith('examinations');
    }

    public function userCgAndExam($user_id, $disciplineId)
    {
        return $this->userCg($user_id)->examinations()->andWhere(['discipline_id'=>$disciplineId]);
    }


    public function specialRightCel()
    {
        return $this->andWhere(
            ['special_right_id' => DictCompetitiveGroupHelper::TARGET_PLACE]);
    }

    public function specialRight($specialRight)
    {
        return $this->andWhere(['special_right_id' => $specialRight]);
    }

    public function currentYear($year)
    {
        return $this->andWhere(['year' => $year]);
    }

    public function filterCg($year, $educationLevelId, $educationFormId,
                             $facultyId, $specialityId, $foreignerStatus, $financingTypeId)
    {
        return $this->andFilterWhere([
            'financing_type_id' => $financingTypeId,
            'faculty_id' => $facultyId,
            'year' => $year,
            'speciality_id' => $specialityId,
            'foreigner_status' => $foreignerStatus,
            'edu_level' => $educationLevelId,
            'education_form_id' => $educationFormId]);
    }

    public function currentAutoYear()
    {
        $currentYear = Date("Y");
        $lastYear = $currentYear - 1;

        return $this->andWhere(['year' => "$lastYear-$currentYear"]);

    }

    public function existsLevelInUniversity()
    {
        return $this->select("edu_level")->currentAutoYear()->groupBy("edu_level");
    }

    public function withCathedra()
    {
        return $this->joinWith('dictCathedra');
    }

    public function currentClass($class)
    {
        return $this->andWhere(['spo_class' => $class]);
    }

    public function onlySpoProgramExcept()
    {
        $onlySpoCgId = DictCompetitiveGroup::find()->andWhere(['only_spo' => true])->select('id')->column();
            return $this->andWhere(['not in', 'id', $onlySpoCgId]);
    }

    public function getAnketa()
    {
        return \Yii::$app->user->identity->anketa();
    }
}