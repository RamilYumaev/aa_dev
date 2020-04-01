<?php


namespace dictionary\models\queries;


use yii\db\ActiveQuery;

class DisciplineCompetitiveQuery extends ActiveQuery
{

    public function priorityOne()
    {
        return $this->andWhere(['priority'=>1]);
    }

    public function priorityTwo()
    {
        return $this->andWhere(['priority'=>2]);
    }

    public function priorityThree()
    {
        return $this->andWhere(['priority'=>3]);
    }


}