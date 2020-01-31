<?php

namespace olympic\repositories;

use common\helpers\FlashMessages;
use olympic\models\UserOlimpiads;

class UserOlimpiadsRepository
{
    public function get($id): UserOlimpiads
    {
        if (!$model = UserOlimpiads::findOne($id)) {
            throw new \DomainException(FlashMessages::get()["noFoundRegistrationOnOlympic"]);
        }
        return $model;
    }

    public function getOlympic($olympic_id, $user_id): UserOlimpiads
    {
        if (!$model = UserOlimpiads::findOne(['olympiads_id' => $olympic_id, 'user_id' => $user_id])) {
            throw new \DomainException(FlashMessages::get()["noFoundRegistrationOnOlympic"]);
        }
        return $model;
    }

    public function getHash($hash): UserOlimpiads
    {
        if (!$model = UserOlimpiads::findOne(['hash' => $hash])) {
            throw new \DomainException("Такой записи нет");
        }
        return $model;
    }


    public function save(UserOlimpiads $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException(FlashMessages::get()["saveError"]);
        }
    }

    public function remove(UserOlimpiads $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException(FlashMessages::get()["deleteError"]);
        }
    }
}