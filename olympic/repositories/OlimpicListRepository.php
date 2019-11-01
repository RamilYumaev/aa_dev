<?php


namespace olympic\repositories;


use olympic\models\OlimpicList;

class OlimpicListRepository
{

    public function get($id): OlimpicList
    {
        if (!$model = OlimpicList::findOne($id)) {
            throw new \DomainException('Olympic не найдено.');
        }
        return $model;
    }

    public function save(OlimpicList $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(OlimpicList $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}