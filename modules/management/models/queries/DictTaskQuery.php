<?php

namespace modules\management\models\queries;

use modules\management\models\ManagementUser;
use yii\db\ActiveQuery;

/**
 * @property $name string
 * @property $color string
 * @property $id integer
 */
class DictTaskQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function allColumn($name = 'name'): array
    {
        return $this->select([$name])->indexBy('id')->column();
    }

    /**
     * @return array
     */
    public function allColumnUser($user_id, $name = 'name'): array
    {
        return $this->joinWith('managementTask')
            ->innerJoin(ManagementUser::tableName(). 'mu', 'mu.post_rate_id = management_task.post_rate_id')
            ->andWhere(['mu.user_id'=> $user_id])
            ->select([$name])
            ->indexBy('id')
            ->column();
    }

}