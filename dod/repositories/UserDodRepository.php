<?php

namespace dod\repositories;

use dod\models\UserDod;

class UserDodRepository
{
    public function get($dod_id, $user_id): UserDod
    {
        if (!$model = UserDod::findOne(['dod_id' => $dod_id, 'user_id' =>$user_id])) {
            throw new \DomainException('UserDod не найдено.');
        }
        return $model;
    }

    public function save(UserDod $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(UserDod $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}