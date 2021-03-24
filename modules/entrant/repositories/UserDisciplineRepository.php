<?php


namespace modules\entrant\repositories;


use modules\entrant\models\UserDiscipline;

class UserDisciplineRepository
{
    public function get($id): UserDiscipline
    {
        if (!$model = UserDiscipline::findOne($id)) {
            throw new \DomainException('Предмет не найден!');
        }
        return $model;
    }

    public function getUser($id, $userId): UserDiscipline
    {
        if (!$model = UserDiscipline::findOne(["user_id" => $userId, "id" => $id])) {
            throw new \DomainException('Заявление уже удалено!');
        }
        return $model;
    }


    public function save(UserDiscipline $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка в процессе сохранения.');
        }
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */

    public function remove(UserDiscipline $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка в процессе удаления.');
        }
    }

}