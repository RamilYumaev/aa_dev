<?php


namespace modules\exam\repositories;
use modules\exam\models\ExamStatement;
use modules\usecase\RepositoryDeleteSaveClass;

class ExamStatementRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamStatement
    {
        if (!$model = ExamStatement::findOne($id)) {
            throw new \DomainException('Заявка на экзамен не найден.');
        }
        return $model;
    }

    public function getExamUserExists($examId, $userId)
    {
        return ExamStatement::find()->andWhere(['exam_id'=>$examId, 'entrant_user_id' =>$userId])->exists();
    }

}