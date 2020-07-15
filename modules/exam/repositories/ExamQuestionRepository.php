<?php


namespace modules\exam\repositories;
use modules\exam\models\ExamQuestion;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamQuestionRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamQuestion
    {
        if (!$model = ExamQuestion::findOne($id)) {
            throw new \DomainException('Вопрос не найден.');
        }
        return $model;
    }

}