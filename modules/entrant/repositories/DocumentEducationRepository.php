<?php


namespace modules\entrant\repositories;
use modules\entrant\models\DocumentEducation;

class DocumentEducationRepository
{
    public function get($id): DocumentEducation
    {
        if (!$model = DocumentEducation::findOne($id)) {
            throw new \DomainException('Документ об образовании не найден.');
        }
        return $model;
    }

    public function getUser($userId): bool
    {
        return  DocumentEducation::find()->where(['user_id' => $userId])->exists();
    }


    public function save(DocumentEducation $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DocumentEducation $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}