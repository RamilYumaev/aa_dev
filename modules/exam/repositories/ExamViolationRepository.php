<?php

namespace modules\exam\repositories;
use modules\exam\models\ExamViolation;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamViolationRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamViolation
    {
        if (!$model = ExamViolation::findOne($id)) {
            throw new \DomainException('Нарушение не нвйдено.');
        }
        return $model;
    }

}