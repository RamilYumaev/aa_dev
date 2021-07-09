<?php


namespace modules\dictionary\repositories;


use modules\dictionary\models\DictSchedule;
use modules\usecase\RepositoryClass;

class DictScheduleRepository extends RepositoryClass
{
    public function __construct(DictSchedule $model)
    {
        $this->model = $model;
    }
}