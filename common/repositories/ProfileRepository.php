<?php

namespace common\repositories;

use common\models\auth\Profiles;

class ProfileRepository
{
    public function get($id): Profiles
    {
    if (!$profile = Profiles::findOne($id)) {
        throw new NotFoundException('Profiles не найдено.');
    }
    return $profile;
    }

    public function getUserId(): ?Profiles
    {
        $profile = Profiles::findOne(['user_id'=> \Yii::$app->user->identity->getId()]);
        return $profile;
    }

    public function save(Profiles $profile): void
    {
        if (!$profile->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Profiles $profile): void
    {
        if (!$profile->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}