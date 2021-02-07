<?php

namespace modules\management\repositories;
use modules\management\models\Schedule;

class ScheduleRepository
{
    /**
     * @param $id
     * @return Schedule
     * @throws \Exception
     */
    public function get($id): Schedule
    {
        if (!$model = Schedule::findOne($id)) {
            throw new \Exception("Категория не найдена");
        }
        return $model;
    }

    /**
     * @param $userId
     * @return Schedule
     */
    public function getUserId($userId): ?Schedule
    {
        return Schedule::findOne(['user_id' => $userId]);
    }

    /**
     * @param Schedule $model
     * @throws \Exception
     */
    public function save(Schedule $model): void
    {
        if (!$model->save()) {
            throw new \Exception("Ошибка при сохранении категории");
        }
    }

    /**
     * @param Schedule $model
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Schedule $model): void
    {
        if(!$model->delete())
        {
            throw new \Exception("Ошибка при удалении категории");
        }
    }

}