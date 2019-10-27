<?php

namespace dictionary\repositories;

use dictionary\models\DictSchools;


class DictSchoolsRepository
{
    public function get($id): DictSchools
    {
        if (!$model = DictSchools::findOne($id)) {
            throw new \DomainException('DictSchools не найдено.');
        }
        return $model;
    }

    public function save(DictSchools $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictSchools $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}