<?php


namespace modules\exam\repositories;
use modules\exam\models\ExamAnswer;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamAnswerRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamAnswer
    {
        if (!$model = ExamAnswer::findOne($id)) {
            throw new \DomainException('Ответ не найден.');
        }
        return $model;
    }

}