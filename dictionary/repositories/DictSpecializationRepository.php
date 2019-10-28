<?php


namespace dictionary\repositories;


use dictionary\models\DictSpecialization;

class DictSpecializationRepository
{
    public function get($id): DictSpecialization
    {
        if (!$model = DictSpecialization::findOne($id)) {
            throw new \DomainException('DictSpecialization не найдено.');
        }
        return $model;
    }

    public function save(DictSpecialization $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictSpecialization $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}