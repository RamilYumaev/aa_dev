<?php


namespace modules\exam\repositories;
use modules\exam\models\Exam;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamRepository extends RepositoryDeleteSaveClass
{
    public function get($id): Exam
    {
        if (!$model = Exam::findOne($id)) {
            throw new \DomainException('Экзамен не найден.');
        }
        return $model;
    }

}