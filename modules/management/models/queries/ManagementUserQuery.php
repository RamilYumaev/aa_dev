<?php

namespace modules\management\models\queries;

use yii\db\ActiveQuery;

/**
 */
class ManagementUserQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function allColumn(): array
    {
        return $this->joinWith('profile')->joinWith('postManagementDirector')
            ->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic, \' \', name_short)'])
            ->indexBy('user_id')->column();
    }

    /**
     * @return array
     */
    public function allColumnTask($task): array
    {
        return $this->joinWith('profile')->joinWith('postManagement')->joinWith('managementTask')
            ->andWhere(['dict_task_id'=> $task])
            ->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic, \' \', name_short)'])
            ->indexBy('user_id')->column();
    }

    /**
     * @return array
     */
    public function allColumnManagementUser($userId): array
    {
        return $this->joinWith('postManagement')
            ->andWhere(['user_id'=> $userId])
            ->select(['post_management.name'])
            ->indexBy('post_management.name')->column();
    }

    /**
     * @return array
     */
    public function allColumnTaskUser($userId): array
    {
        return $this->joinWith('postManagement')
            ->joinWith('managementTask')
            ->andWhere(['user_id'=> $userId])
            ->select(['management_task.name'])
            ->indexBy('management_task.id')->column();
    }

}