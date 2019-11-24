<?php
namespace testing\repositories;

use testing\models\Answer;

class AnswerRepository
{
    public function get($id): Answer
    {
        if (!$model = Answer::findOne($id)) {
            throw new \DomainException( 'Answer не найдено.');
        }
        return $model;
    }

    public function save(Answer $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Answer $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}