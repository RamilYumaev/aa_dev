<?php


namespace dictionary\repositories;


use dictionary\models\DisciplineCompetitiveGroup;

class DisciplineCompetitiveGroupRepository
{
    public function get($id): DisciplineCompetitiveGroup
    {
        if (!$model = DisciplineCompetitiveGroup::findOne($id)) {
            throw new \DomainException('DisciplineCompetitiveGroup не найдено.');
        }
        return $model;
    }

    public function save(DisciplineCompetitiveGroup $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DisciplineCompetitiveGroup $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}