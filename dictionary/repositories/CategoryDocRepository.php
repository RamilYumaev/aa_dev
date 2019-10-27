<?php

namespace dictionary\repositories;

use dictionary\models\CategoryDoc;
use yii\web\NotFoundHttpException;


class CategoryDocRepository
{
    public function get($id): CategoryDoc
    {
        if (!$model = CategoryDoc::findOne($id)) {
            throw new NotFoundHttpException('CategoryDoc не найдено.');
        }
        return $model;
    }

    public function save(CategoryDoc $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(CategoryDoc $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}