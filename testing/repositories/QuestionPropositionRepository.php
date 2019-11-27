<?php
namespace testing\repositories;

use testing\models\QuestionProposition;

class QuestionPropositionRepository
{
    public function get($id): QuestionProposition
    {
        if (!$model = QuestionProposition::findOne($id)) {
            throw new \DomainException( 'QuestionProposition не найдено.');
        }
        return $model;
    }

    public function save(QuestionProposition $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(QuestionProposition $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}