<?php


namespace modules\exam\repositories;
use modules\exam\models\Exam;
use modules\exam\models\ExamStatement;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ?Exam
    {
        if (!$model = Exam::findOne($id)) {
            throw new \DomainException('Экзамен не найден.');
        }
        return $model;
    }

    public function getDisciplineId($discipline): ? Exam
    {
        return Exam::findOne(['discipline_id' => $discipline]);
    }

}