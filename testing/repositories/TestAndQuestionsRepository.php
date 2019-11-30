<?php
namespace testing\repositories;

use testing\models\TestAndQuestions;

class TestAndQuestionsRepository
{
    public function get($id): TestAndQuestions
    {
        if (!$model = TestAndQuestions::findOne($id)) {
            throw new \DomainException( 'TestAndQuestions не найдено.');
        }
        return $model;
    }

    public function isTestGroupInTest($test_id,  $test_group_id)
    {
        return TestAndQuestions::findOne(['test_id' => $test_id, 'test_group_id' => $test_group_id]);
    }

    public function isQuestionInTest($test_id, $question_id)
    {
       return  TestAndQuestions::findOne(['test_id' => $test_id, 'question_id' => $question_id]);
    }

    public function save(TestAndQuestions $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(TestAndQuestions $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}