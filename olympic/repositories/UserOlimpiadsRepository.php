<?php

namespace olympic\repositories;

use olympic\models\UserOlimpiads;

class UserOlimpiadsRepository
{
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