<?php


namespace modules\entrant\repositories;

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

}