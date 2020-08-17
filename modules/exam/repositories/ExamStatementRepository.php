<?php


namespace modules\exam\repositories;
use modules\exam\helpers\ExamStatementHelper;
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

    public function getExamUserTypeExists($examId, $userId, $type)
    {
        return ExamStatement::find()->andWhere(['exam_id'=>$examId, 'entrant_user_id' =>$userId, 'type' => $type])->exists();
    }

    public function getExamStatusSuccessExists($examId, $userId)
    {
        return ExamStatement::find()->andWhere(['exam_id'=>$examId, 'status'=>ExamStatementHelper::SUCCESS_STATUS, 'entrant_user_id' =>$userId])->exists();
    }

    public function getExamStatusSuccess($examId, $userId)
    {
        return ExamStatement::findOne(['exam_id'=>$examId, 'status'=>ExamStatementHelper::SUCCESS_STATUS, 'entrant_user_id' =>$userId]);
    }

}