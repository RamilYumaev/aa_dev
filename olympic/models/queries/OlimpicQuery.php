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

}