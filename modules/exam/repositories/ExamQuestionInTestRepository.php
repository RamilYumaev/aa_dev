<?php

namespace modules\exam\repositories;
use modules\exam\models\ExamQuestionInTest;
use modules\usecase\RepositoryDeleteSaveClass;
use testing\models\TestAndQuestions;

class ExamQuestionInTestRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamQuestionInTest
    {
        if (!$model = ExamQuestionInTest::findOne($id)) {
            throw new \DomainException('Вопрос в тесте не найден.');
        }
        return $model;
    }

    public function isQuestionGroupInTest($test_id, $question_group_id)
    {
        return ExamQuestionInTest::findOne(['test_id' => $test_id, 'question_group_id' => $question_group_id]);
    }

    public function isQuestionInTest($test_id, $question_id)
    {
        return  ExamQuestionInTest::findOne(['test_id' => $test_id, 'question_id' => $question_id]);
    }

}