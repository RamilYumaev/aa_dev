<?php

namespace modules\dictionary\repositories;
use modules\dictionary\models\ScheduleVolunteering;
use modules\usecase\RepositoryClass;

class ScheduleVolunteeringRepository extends RepositoryClass
{
    public function __construct(ScheduleVolunteering $model)
    {
        $this->model = $model;
    }
}