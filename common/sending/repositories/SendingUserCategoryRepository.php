<?php


namespace common\sending\repositories;


use common\sending\models\SendingUserCategory;

class SendingUserCategoryRepository
{
    public function get($id): SendingUserCategory
    {
        if (!$model = SendingUserCategory::findOne($id)) {
            throw new \DomainException( 'DSendingUserCategory не найдено.');
        }
        return $model;
    }

    public function save(SendingUserCategory $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(SendingUserCategory $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}