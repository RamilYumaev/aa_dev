<?php

namespace olympic\repositories\auth;

use olympic\models\auth\Profiles;



class ProfileRepository
{
    public function get($id): Profiles
    {
        if (!$profile = Profiles::findOne($id)) {
            throw new \DomainException('Profiles не найдено.');
        }
        return $profile;
    }

    public function getUserId(): ?Profiles
     {
        $profile = Profiles::findOne(['user_id' => \Yii::$app->user->identity->getId()]);
        return $profile;
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