<?php


namespace modules\entrant\repositories;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionRecord;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementRejectionRecordRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ?StatementRejectionRecord
    {
        if (!$model= StatementRejectionRecord::findOne($id)) {
            throw new \DomainException('Заявление не найдено!');
        }
        return  $model;
    }

    public function isStatementRejection($userId, $cgId)
    {
        if (StatementRejectionRecord::findOne(['user_id'=>$userId, 'cg_id'=>$cgId])) {
            throw new \DomainException('Заявление создано!');
        }
    }


}