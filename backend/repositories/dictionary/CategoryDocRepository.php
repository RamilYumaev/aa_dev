<?php

namespace backend\repositories\dictionary;

use backend\models\dictionary\CategoryDoc;


class CategoryDocRepository
{
    public function get($id): CategoryDoc
    {
        if (!$catDoc = CategoryDoc::findOne($id)) {
            throw new NotFoundException('CategoryDoc не найдено.');
        }
        return $catDoc;
    }

    public function save(CategoryDoc $categoryDoc): void
    {
        if (!$categoryDoc->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(CategoryDoc $categoryDoc): void
    {
        if (!$categoryDoc->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}