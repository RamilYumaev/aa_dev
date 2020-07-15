<?php


namespace modules\exam\repositories;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamResult;
use modules\usecase\RepositoryDeleteSaveClass;
use testing\models\TestResult;

class ExamResultRepository extends RepositoryDeleteSaveClass
{
    public function get($attempt_id, $question_id, $tq_id): ExamResult
    {
        if (!$model = ExamResult::findOne(['attempt_id' => $attempt_id, 'question_id'=> $question_id, 'tq_id' => $tq_id])) {
            throw new \DomainException( 'Такой попытки ответа на вопрос не существует.');
        }
        return $model;
    }

}