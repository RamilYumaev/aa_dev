<?php


namespace modules\entrant\repositories;
use modules\entrant\models\PassportData;

class PassportDataRepository
{
    public function get($id): PassportData
    {
        if (!$model = PassportData::findOne($id)) {
            throw new \DomainException('Паспортные данные не найдены.');
        }
        return $model;
    }

    public function save(PassportData $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(PassportData $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}