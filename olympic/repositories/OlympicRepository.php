<?php


namespace olympic\repositories;


use olympic\models\Olympic;

class OlympicRepository
{

    public function get($id): Olympic
    {
        if (!$model = Olympic::findOne($id)) {
            throw new \DomainException('Olympic не найдено.');
        }
        return $model;
    }

    public function save(Olympic $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Olympic $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}