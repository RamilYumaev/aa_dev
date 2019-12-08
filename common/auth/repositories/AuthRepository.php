<?php

namespace common\auth\repositories;

use common\auth\models\Auth;

class AuthRepository
{
    public function findBySourceAndSourceId($source, $id): ?Auth
    {
        return Auth::findOne(['source' => $source, 'source_id' => $id]);
    }

    public function save(Auth $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(\common\auth\models\Auth $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}