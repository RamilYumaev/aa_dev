<?php


namespace dictionary\repositories;


use dictionary\models\DictCompetitiveGroup;

class DictCompetitiveGroupRepository
{
    public function get($id): DictCompetitiveGroup
    {
        if (!$model = DictCompetitiveGroup::findOne($id)) {
            throw new  \DomainException('DictCompetitiveGroup не найдено.');
        }
        return $model;
    }

    public function save(DictCompetitiveGroup $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictCompetitiveGroup $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}