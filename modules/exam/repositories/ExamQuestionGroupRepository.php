<?php


namespace modules\exam\repositories;
use modules\exam\models\Exam;
use modules\exam\models\ExamQuestionGroup;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamQuestionGroupRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamQuestionGroup
    {
        if (!$model = ExamQuestionGroup::findOne($id)) {
            throw new \DomainException('Группа вопросов не найдена.');
        }
        return $model;
    }

}