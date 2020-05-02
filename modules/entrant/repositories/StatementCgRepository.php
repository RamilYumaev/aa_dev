<?php
namespace modules\entrant\repositories;

use modules\entrant\models\StatementCg;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementCgRepository extends RepositoryDeleteSaveClass
{
    public function get($id): StatementCg
    {
        if (!$model = StatementCg::findOne($id)) {
            throw new \DomainException('Прочий документ не найден.');
        }
        return $model;
    }

}