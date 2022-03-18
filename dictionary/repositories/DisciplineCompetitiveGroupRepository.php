<?php


namespace dictionary\repositories;


use dictionary\models\DisciplineCompetitiveGroup;

class DisciplineCompetitiveGroupRepository
{
    public function get($discipline_id, $competitive_group_id): DisciplineCompetitiveGroup
    {
        if (!$model = DisciplineCompetitiveGroup::findOne(['discipline_id'=>$discipline_id, 'competitive_group_id'=>$competitive_group_id])) {

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