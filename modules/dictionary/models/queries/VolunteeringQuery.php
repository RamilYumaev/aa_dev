<?php


namespace modules\dictionary\models\queries;


use modules\management\models\PostRateDepartment;
use yii\db\ActiveQuery;

class VolunteeringQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function allColumn(): array
    {
        return $this->joinWith('entrantJob')
            ->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])
            ->indexBy('job_entrant_id')->column();
    }
}