<?php


namespace modules\dictionary\repositories;
use modules\dictionary\models\DictPostEducation;

class DictPostEducationRepository
{
    public function get($id): DictPostEducation
    {
        if (!$model = DictPostEducation::findOne($id)) {
            throw new \DomainException('Должность не найдена.');
        }
        return $model;
    }

    public function save(DictPostEducation $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictPostEducation $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}