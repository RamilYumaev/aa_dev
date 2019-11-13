<?php

namespace olympic\repositories;
use olympic\models\OlimpicNomination;

class OlimpicNominationRepository
{

    public function get($id): OlimpicNomination
    {
        if (!$model = OlimpicNomination::findOne($id)) {
            throw new \DomainException('Olympic не найдено.');
        }
        return $model;
    }

    public function save(OlimpicNomination $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(OlimpicNomination $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}