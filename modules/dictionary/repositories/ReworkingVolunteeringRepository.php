<?php

namespace modules\dictionary\repositories;
use modules\dictionary\models\ReworkingVolunteering;
use modules\usecase\RepositoryClass;

class ReworkingVolunteeringRepository extends RepositoryClass
{
    public function __construct(ReworkingVolunteering $model)
    {
        $this->model = $model;
    }
}