<?php

namespace modules\management\repositories;
use modules\management\models\ManagementUser;

class ManagementUserRepository
{
    /**
     * @param ManagementUser $model
     * @throws \Exception
     */
    public function save(ManagementUser $model): void
    {
        if (!$model->save()) {
            throw new \Exception("Ошибка при сохранении");
        }
    }

    /**
     * @param ManagementUser $model
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(ManagementUser $model): void
    {
        if(!$model->delete())
        {
            throw new \Exception("Ошибка при удалении");
        }
    }

}