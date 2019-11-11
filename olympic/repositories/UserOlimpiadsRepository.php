<?php

namespace olympic\repositories;

use olympic\models\UserOlimpiads;

class UserOlimpiadsRepository
{
    public function get($olympic_id, $user_id): UserOlimpiads
    {
        if (!$model = UserOlimpiads::findOne(['olympiads_id' => $olympic_id, 'user_id' => $user_id])) {
            throw new \DomainException('UserDod не найдено.');
        }
        return $model;
    }

    public function save(UserOlimpiads $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(UserOlimpiads $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}