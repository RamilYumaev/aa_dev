<?php


namespace dod\repositories;


use dod\models\Dod;

class DodRepository
{
    public function get($id): Dod
    {
        if (!$model = Dod::findOne($id)) {
            throw new \DomainException('Dod не найдено.');
        }
        return $model;
    }

    public function save(Dod $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Dod $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}