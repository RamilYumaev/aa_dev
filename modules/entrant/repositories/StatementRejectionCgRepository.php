<?php

namespace modules\entrant\repositories;

use modules\entrant\models\StatementRejectionCg;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementRejectionCgRepository extends RepositoryDeleteSaveClass
{
    public function getIdUser($id, $user): ?StatementRejectionCg
    {
        if (!$model= StatementRejectionCg::find()->statementOne($id, $user)) {
            throw new \DomainException('Заявление не найдено!');
        }
        return  $model;
    }

    public function get($id): ?StatementRejectionCg
    {
        if (!$model= StatementRejectionCg::findOne($id)) {
            throw new \DomainException('Заявление не найдено!');
        }
        return  $model;
    }

    public function isStatementRejection($id)
    {
        if (StatementRejectionCg::findOne(['statement_cg'=>$id])) {
            throw new \DomainException('Заявление создано!');
        }
    }


}