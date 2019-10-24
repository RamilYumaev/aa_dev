<?php

namespace backend\repositories\dictionary;

use backend\models\dictionary\DictClass;

class DictClassRepository
{
    public function get($id): DictClass
    {
        if (!$model = DictClass::findOne($id)) {
            throw new NotFoundException('DictClass не найдено.');
        }
        return $model;
    }

    public function save(DictClass $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictClass $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}