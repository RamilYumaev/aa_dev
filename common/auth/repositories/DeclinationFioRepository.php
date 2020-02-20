<?php

namespace common\auth\repositories;

use common\auth\models\DeclinationFio;


class DeclinationFioRepository
{
    public function findByUser(): ?DeclinationFio
    {
        return DeclinationFio::findOne(['user_id'=> \Yii::$app->user->identity->getId()]);
    }

    public function findByUserId($user_id): ?DeclinationFio
    {
        return DeclinationFio::findOne(['user_id'=> $user_id]);
    }

    public function get($id): DeclinationFio
    {
        if (!$model = DeclinationFio::findOne($id)) {
            throw new \DomainException( 'Ничего не найдено');
        }
        return $model;
    }

    public function save(DeclinationFio $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DeclinationFio $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}