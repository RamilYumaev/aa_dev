<?php

namespace modules\dictionary\repositories;


use modules\dictionary\models\JobEntrant;
use modules\usecase\RepositoryDeleteSaveClass;

class JobEntrantRepository extends RepositoryDeleteSaveClass
{
    public function get($id): JobEntrant
    {
        if (!$model = JobEntrant::findOne($id)) {
            throw new \DomainException("Данные не найдены");
        }
        return $model;
    }

}