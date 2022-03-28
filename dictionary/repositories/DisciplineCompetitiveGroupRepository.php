<?php


namespace dictionary\repositories;


use dictionary\models\DisciplineCompetitiveGroup;

class DisciplineCompetitiveGroupRepository
{
    public function get($discipline_id, $competitive_group_id): DisciplineCompetitiveGroup
    {
        if (!$model = DisciplineCompetitiveGroup::findOne(['discipline_id'=>$discipline_id, 'competitive_group_id'=>$competitive_group_id])) {
            throw new \DomainException('Дисциплина не найдены.');
        }
        return $model;
    }

    public function isCg($discipline_id, $competitive_group_id)
    {
        if (DisciplineCompetitiveGroup::findOne(['discipline_id'=>$discipline_id, 'competitive_group_id'=>$competitive_group_id])) {
            throw new \DomainException('Такой предмет существует в конкурсной группе');
        }
    }

    public function isSpo($discipline_id, $competitive_group_id)
    {
        if (DisciplineCompetitiveGroup::findOne(['spo_discipline_id'=>$discipline_id, 'competitive_group_id'=>$competitive_group_id])) {
            throw new \DomainException('Такой предмет СПО существует в конкурсной группе');
        }
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