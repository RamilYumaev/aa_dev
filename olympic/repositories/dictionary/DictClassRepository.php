<?php

namespace olympic\repositories\dictionary;

use olympic\models\dictionary\DictClass;
use yii\web\NotFoundHttpException;

class DictClassRepository
{
    public function get($id): DictClass
    {
        if (!$model = DictClass::findOne($id)) {
            throw new NotFoundHttpException('dictClass не найдено.');
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