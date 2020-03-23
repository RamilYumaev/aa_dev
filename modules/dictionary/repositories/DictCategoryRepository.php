<?php

namespace modules\dictionary\repositories;


use modules\dictionary\models\DictCategory;
use phpDocumentor\Reflection\Types\Void_;

class DictCategoryRepository
{
    public function get($id): DictCategory
    {
        if (!$model = DictCategory::findOne($id)) {
            throw new \DomainException("Категория не найдена");
        }
        return $model;
    }

    public function save(DictCategory $model): void
    {
        if (!$model->save()) {
            throw new \DomainException("Ошибка при сохранении категории");
        }
    }
    public function remove(DictCategory $model): void
    {
        if(!$model->delete())
        {
            throw new \DomainException("Ошибка при удалении категории");
        }
    }

}