<?php


namespace dictionary\repositories;


use dictionary\models\DictSpeciality;

class DictSpecialityRepository
{
    public function get($id): DictSpeciality
    {
        if (!$model = DictSpeciality::findOne($id)) {
            throw new \DomainException('DictSpeciality не найдено.');
        }
        return $model;
    }

    public function save(DictSpeciality $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictSpeciality $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}