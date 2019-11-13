<?php

namespace olympic\repositories;
use olympic\models\SpecialTypeOlimpic;

class SpecialTypeOlimpicRepository
{

    public function get($id): SpecialTypeOlimpic
    {
        if (!$model = SpecialTypeOlimpic::findOne($id)) {
            throw new \DomainException('Olympic не найдено.');
        }
        return $model;
    }

    public function save(SpecialTypeOlimpic $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(SpecialTypeOlimpic $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}