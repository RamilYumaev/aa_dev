<?php

namespace dictionary\models\queries;

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

    public function allActualFaculty($year)
    {
        return $this->distinct()->select('faculty_id')->andWhere(['year' => $year])->column();
    }

    public function getAllCg($year)
    {
        return $this->andWhere(['year' => $year])->all();
    }

}