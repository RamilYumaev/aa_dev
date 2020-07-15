<?php


namespace modules\exam\repositories;
use modules\exam\models\ExamTest;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamTestRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamTest
    {
        if (!$model = ExamTest::findOne($id)) {
            throw new \DomainException('Тест не найден.');
        }
        return $model;
    }

}