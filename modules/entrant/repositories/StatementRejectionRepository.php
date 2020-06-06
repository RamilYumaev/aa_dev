<?php


namespace modules\entrant\repositories;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementRejection;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementRejectionRepository extends RepositoryDeleteSaveClass
{
    public function getIdUser($id, $user): ?StatementRejection
    {
        if (!$model= StatementRejection::find()->statementOne($id, $user)) {
            throw new \DomainException('Заявление не найдено!');
        }
        return  $model;
    }

    public function get($id): ?StatementRejection
    {
        if (!$model= StatementRejection::findOne($id)) {
            throw new \DomainException('Заявление не найдено!');
        }
        return  $model;
    }

    public function isStatementRejection($id)
    {
        if (StatementRejection::findOne(['statement_id'=>$id])) {
            throw new \DomainException('Заявление создано!');
        }
    }


}