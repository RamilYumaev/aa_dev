<?php

namespace olympic\models\queries;

class OlimpicQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => 0]);
    }

    /**
     * @return $this
     */
    public function manager($manager)
    {
        return $this->andWhere(['managerId' => $manager]);
    }

    /**
     * @return $this
     */
    public function id($id)
    {
        return $this->andWhere(['id' => $id]);
    }


}