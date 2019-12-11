<?php


namespace common\sending\repositories;


use common\sending\models\DictSendingUserCategory;

class DictSendingUserCategoryRepository
{
    public function get($id): DictSendingUserCategory
    {
        if (!$model = DictSendingUserCategory::findOne($id)) {
            throw new \DomainException( 'DDictSendingUserCategory не найдено.');
        }
        return $model;
    }

    public function save(DictSendingUserCategory $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictSendingUserCategory $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}