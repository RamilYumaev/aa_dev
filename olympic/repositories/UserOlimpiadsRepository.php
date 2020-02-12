<?php

namespace olympic\repositories;

use common\helpers\FlashMessages;
use olympic\models\OlimpicList;
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

    public function isUserOlympic($olympic_id, $user_id): bool
    {
       return UserOlimpiads::find()->andWhere(['olympiads_id' => $olympic_id, 'user_id' => $user_id])->exists();
    }

    public function isOlympic($olympic_id): bool
    {
        return UserOlimpiads::find()->andWhere(['olympiads_id' => $olympic_id])->exists();
    }


    public function isOlympicUserYear($year,  $user_id): bool
    {
        return UserOlimpiads::find()
            ->alias('uo')
            ->innerJoin(OlimpicList::tableName(). ' olympic', 'olympic.id = uo.olympiads_id')
            ->andWhere(['user_id' => $user_id])
            ->andWhere(['olympic.year'=>$year])
            ->exists();
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