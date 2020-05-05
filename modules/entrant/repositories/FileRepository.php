<?php


namespace modules\entrant\repositories;
use modules\entrant\models\File;

class FileRepository
{
    public function get($id): File
    {
        if (!$model = File::findOne($id)) {
            throw new \DomainException('Файл не найден.');
        }
        return $model;
    }

    public function getFullFile($user, $modelName, $recordId, $position): bool
    {
        return File::find()->defaultQueryPositionUser($user, $modelName, $recordId, $position)->exists();
    }

    public function save(File $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(File $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}