<?php


namespace dictionary\models\queries;


class FacultyQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function faculty($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    public function facultyAis($id)
    {
        return $this->andWhere(['ais_id' => $id]);
    }
}