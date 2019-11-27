<?php
namespace testing\repositories;

use testing\models\AnswerCloze;

class AnswerClozeRepository
{
    public function get($id): AnswerCloze
    {
        if (!$model = AnswerCloze::findOne($id)) {
            throw new \DomainException( 'AnswerCloze не найдено.');
        }
        return $model;
    }

    public function save(AnswerCloze $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(AnswerCloze $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}