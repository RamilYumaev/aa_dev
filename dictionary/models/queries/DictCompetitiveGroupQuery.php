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

}