<?php


namespace modules\entrant\repositories;
use modules\entrant\models\OtherDocument;

class OtherDocumentRepository
{
    public function get($id): OtherDocument
    {
        if (!$model = OtherDocument::findOne($id)) {
            throw new \DomainException('Прочий документ не найден.');
        }
        return $model;
    }

    public function save(OtherDocument $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(OtherDocument $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}