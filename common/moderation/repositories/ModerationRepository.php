<?php


namespace common\moderation\repositories;
use common\moderation\models\Moderation;

class ModerationRepository
{
    public function get($id): Moderation
    {
        if (!$model = Moderation::findOne($id)) {
            throw new \DomainException( 'DSending не найдено.');
        }
        return $model;
    }

    public function save(Moderation $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Moderation $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}