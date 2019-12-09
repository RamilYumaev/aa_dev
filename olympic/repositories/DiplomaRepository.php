<?php

namespace olympic\repositories;
use olympic\models\Diploma;

class DiplomaRepository
{

    public function get($id): Diploma
    {
        if (!$model = Diploma::findOne($id)) {
            throw new \DomainException('Диплом не найден.');
        }
        return $model;
    }

    public function save(Diploma $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Diploma $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}