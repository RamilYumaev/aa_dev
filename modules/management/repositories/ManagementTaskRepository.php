<?php

namespace modules\management\repositories;
use modules\management\models\ManagementTask;

class ManagementTaskRepository
{
    /**
     * @param ManagementTask $model
     * @throws \Exception
     */
    public function save(ManagementTask $model): void
    {
        if (!$model->save()) {
            throw new \Exception("Ошибка при сохранении");
        }
    }

    /**
     * @param ManagementTask $model
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(ManagementTask $model): void
    {
        if(!$model->delete())
        {
            throw new \Exception("Ошибка при удалении");
        }
    }

}