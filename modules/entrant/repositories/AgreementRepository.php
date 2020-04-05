<?php


namespace modules\entrant\repositories;
use modules\entrant\models\Agreement;

class AgreementRepository
{
    public function get($id): Agreement
    {
        if (!$model = Agreement::findOne($id)) {
            throw new \DomainException('Язык не найден.');
        }
        return $model;
    }

    public function save(Agreement $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Agreement $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}