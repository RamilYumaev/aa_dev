<?php

namespace modules\management\models\queries;

use modules\management\models\PostRateDepartment;
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
        $array = [];
        $query = $this->joinWith('profile')->joinWith('postManagementDirector')
            ->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])
            ->indexBy('user_id')->column();
        foreach ($query as $key => $value) {
            $array[$key] = $value." ". implode(', ', PostRateDepartment::find()->getAllColumnShortUser($key));
        }
        return $array;
    }



    /**
     * @return array
     */
    public function allColumnTask($task): array
    {
        return $this->joinWith('profile')->joinWith('postManagement')->joinWith('managementTask')
            ->andWhere(['dict_task_id'=> $task])
            ->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])
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

    public function user($userId)
    {
        return $this->andWhere(['user_id'=> $userId]);
    }

    public function assistant()
    {
        return $this->andWhere(['is_assistant'=> true]);
    }

    public function userDirector($userId) {
       return  $this->joinWith('postManagementDirector')->user($userId);
    }
}