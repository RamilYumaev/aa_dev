<?php

namespace modules\dictionary\repositories;


use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\Volunteering;
use modules\usecase\RepositoryDeleteSaveClass;

class VolunteeringRepository extends RepositoryDeleteSaveClass
{
    public function get($id): Volunteering
    {
        if (!$model = Volunteering::findOne($id)) {
            throw new \DomainException("Данные не найдены");
        }
        return $model;
    }

}