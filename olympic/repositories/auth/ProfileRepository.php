<?php

namespace olympic\repositories\auth;

use olympic\models\auth\Profiles;

class ProfileRepository
{
    public function get($id): Profiles
    {
    if (!$model = Profiles::findOne($id)) {
        throw new NotFoundException('Profiles не найдено.');
    }
    return $model;
    }

    public function getUserId(): ?Profiles
    {
        $model = Profiles::findOne(['user_id'=> \Yii::$app->user->identity->getId()]);
        return $model;
    }

    public function save(Profiles $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Profiles $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}