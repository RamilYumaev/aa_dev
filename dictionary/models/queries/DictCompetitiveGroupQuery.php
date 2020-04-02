<?php

namespace dictionary\models\queries;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\Faculty;

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

    public function allActualFacultyWithoutBranch($year)
    {
        return $this
            ->select('faculty_id')
            ->withoutBranch()
            ->andWhere(['year' => $year]);
    }

    public function getAllCg($year)
    {
        return $this->andWhere(['year' => $year])->all();
    }

    public function faculty($facultyId)
    {
        return $this->andWhere(['faculty_id' => $facultyId]);
    }

    public function withoutBranch()
    {
        return $this
            ->andWhere(['not in', 'faculty_id', Faculty::find()
                ->select('id')
                ->andWhere(['filial' => DictFacultyHelper::YES_FILIAL])->column()]);
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
                'edu_level' => $cgContract->edu_level,
                'education_form_id' => $cgContract->education_form_id]
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

    public function finance($financeId)
    {
        return $this->andWhere(
            ['financing_type_id' => $financeId]);
    }


    public function currentYear($year)
    {
        return $this->andWhere(['year' => $year]);
    }

    public function currentAutoYear()
    {
        $currentYear = Date("Y");
        $lastYear = $currentYear - 1;

        return $this->andWhere(['year' => "$lastYear-$currentYear"]);

    }

}