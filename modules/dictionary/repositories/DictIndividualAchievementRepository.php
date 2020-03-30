<?php


namespace modules\dictionary\repositories;
use modules\dictionary\models\DictIndividualAchievement;

class DictIndividualAchievementRepository
{
    public function get($id): DictIndividualAchievement
    {
        if (!$model = DictIndividualAchievement::findOne($id)) {
            throw new \DomainException('ИД не найдено.');
        }
        return $model;
    }

    public function save(DictIndividualAchievement $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictIndividualAchievement $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}