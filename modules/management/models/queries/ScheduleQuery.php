<?php

namespace modules\management\models\queries;

use yii\db\ActiveQuery;

class ScheduleQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function getAllColumnDirector(): array
    {
        return $this->joinWith('profile')->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])->indexBy('user_id')->column();
    }

    public function allColumnResponsible($nameColumn): array
    {
        return $this->joinWith('profile')->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic,  \' (\', '.$nameColumn.', \')\')'])
            ->andWhere(['not', [$nameColumn => '']])->indexBy('user_id')->column();
    }
}