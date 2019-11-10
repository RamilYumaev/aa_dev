<?php


namespace dod\repositories;


use dod\models\DateDod;

class DateDodRepository
{
    public function get($id): DateDod
    {
        if (!$model = DateDod::findOne($id)) {
            throw new \DomainException('DateDod не найдено.');
        }
        return $model;
    }

    public function save(DateDod $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DateDod $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}