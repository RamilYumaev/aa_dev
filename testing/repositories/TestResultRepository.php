<?php
namespace testing\repositories;

use testing\models\TestResult;

class TestResultRepository
{
    public function get($attempt_id, $question_id, $tq_id): TestResult
    {
        if (!$model = TestResult::findOne(['attempt_id' => $attempt_id, 'question_id'=> $question_id, 'tq_id' => $tq_id])) {
            throw new \DomainException( 'Такой попытки ответа на вопрос не существует.');
        }
        return $model;
    }

    public function save(TestResult $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(TestResult $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}