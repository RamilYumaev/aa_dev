<?php


namespace modules\exam\repositories;
use modules\exam\models\ExamAnswerNested;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamAnswerNestedRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamAnswerNested
    {
        if (!$model = ExamAnswerNested::findOne($id)) {
            throw new \DomainException('Ответ не найден.');
        }
        return $model;
    }

}