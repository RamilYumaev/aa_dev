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

    public function allActualFacultyWithoutBranch()
    {
        return $this
            ->select('faculty_id')
            ->withoutBranch()
            ->allowDeadLineEducationForm()
            ->currentAutoYear();
    }

    public function allowDeadLineEducationForm()
    {
        if ((\Yii::$app->user->identity->setting()->allowBacCseOchBudget())) {
            return $this->andWhere(['in', 'education_form_id',
                [DictCompetitiveGroupHelper::EDU_FORM_OCH, DictCompetitiveGroupHelper::EDU_FORM_OCH_ZAOCH]]);
        } else {
            return $this->andWhere(['education_form_id' => DictCompetitiveGroupHelper::EDU_FORM_ZAOCH]);
        }
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
        $anketa = \Yii::$app->user->identity->anketa();
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

    public function findBudgetAnalog($cgContract)
    {
        return $this->andWhere(
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
    }

    public function foreignerStatus($foreignerStatus)
    {
        return $this->andWhere(['foreigner_status' => $foreignerStatus]
        );
    }

    public function formEdu($formId)
    {
        return $this->andWhere(['education_form_id' => $formId]
        );
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

}