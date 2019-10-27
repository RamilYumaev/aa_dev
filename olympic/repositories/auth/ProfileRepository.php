<?php

namespace olympic\repositories\auth;

use olympic\models\auth\Profiles;

NotFoundException


class ProfileRepository
{
    public function get($id): Profiles
    {
        <<<<
        <<< HEAD:common/repositories/ProfileRepository.php
        if (!$profile = Profiles::findOne($id)) {
            throw new NotFoundException('Profiles не найдено.');
        }
        return $profile;
=======
    if (!$model = Profiles::findOne($id)) {
        throw new NotFoundException('Profiles не найдено.');
    }
    return $model;
>>>>>>> #10:olympic/repositories/auth/ProfileRepository.php
    }

    public function getUserId(): ?Profiles
    {
<<<<<<< HEAD:common/repositories/ProfileRepository.php
        $profile = Profiles::findOne(['user_id' => \Yii::$app->user->identity->getId()]);
        return $profile;
=======
        $model = Profiles::findOne(['user_id'=> \Yii::$app->user->identity->getId()]);
        return $model;
>>>>>>> #10:olympic/repositories/auth/ProfileRepository.php
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