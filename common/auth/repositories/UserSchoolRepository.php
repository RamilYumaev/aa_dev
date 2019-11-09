<?php

namespace common\auth\repositories;

use common\auth\models\UserSchool;

class UserSchoolRepository
{
    public function save(UserSchool $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(UserSchool $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}