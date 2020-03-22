<?php


namespace modules\entrant\repositories;
use modules\entrant\models\CseSubjectResult;

class CseSubjectResultRepository
{
    public function get($id): CseSubjectResult
    {
        if (!$model = CseSubjectResult::findOne($id)) {
            throw new \DomainException('Данные не найдены.');
        }
        return $model;
    }

    public function save(CseSubjectResult $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(CseSubjectResult $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}