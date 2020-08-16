<?php

namespace modules\exam\repositories;
use modules\exam\models\ExamQuestionNested;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamQuestionNestedRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamQuestionNested
    {
        if (!$model = ExamQuestionNested::findOne($id)) {
            throw new \DomainException('Вопрос не найден.');
        }
        return $model;
    }

}