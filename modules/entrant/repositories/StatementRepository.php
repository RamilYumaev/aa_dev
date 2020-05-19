<?php


namespace modules\entrant\repositories;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ?Statement
    {
        if (!$model = Statement::findOne($id)) {
            throw new \DomainException('Заявление не найдено!');
        }
        return  $model;
    }

    public function getStatementFull($userId, $facultyId, $specialityId,  $specialRightId, $eduLevel)
    {
        if (!$model = Statement::find()->user($userId)->defaultWhere($facultyId, $specialityId,  $specialRightId, $eduLevel, StatementHelper::STATUS_DRAFT)->one()) {
            return false;
        }
        return  $model;
    }

    public function getStatementStatusNoDraft($userId)
    {
       return  Statement::find()->user($userId)->andWhere(['>', 'status', StatementHelper::STATUS_DRAFT])->exists();
    }

}