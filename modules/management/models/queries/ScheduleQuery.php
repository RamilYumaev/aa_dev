<?php

namespace modules\management\models\queries;

use yii\db\ActiveQuery;

class ScheduleQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function getAllColumnUser(): array
    {
        return $this->joinWith('profile')->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])->indexBy('user_id')->column();
    }

    public function getAllColumnDateOff(): array
    {
        return $this->joinWith('profile')->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])->indexBy('schedule.id')->column();
    }

    public function user($userId)
    {
        return $this->andWhere(['user_id'=> $userId]);
    }
}