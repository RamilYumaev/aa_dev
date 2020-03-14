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
        return $this->distinct()
            ->select('faculty_id')
            ->withoutBranch()
            ->andWhere(['year' => $year])
            ->column();
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

    public function budgetAndContractOnly()
    {
        return $this->andWhere(['or',
            ['financing_type_id' => DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET],
            ['only_pay_status' => true]]);
    }


    public function contractOnly()
    {
        return $this->andWhere(
            ['financing_type_id' => DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT]);
    }

    public function currentYear($year)
    {
       return  $this->andWhere(['year' => $year]);
    }

}