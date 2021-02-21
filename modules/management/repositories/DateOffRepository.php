<?php


namespace modules\management\repositories;


use modules\management\models\DateOff;
use modules\usecase\RepositoryClass;

class DateOffRepository extends RepositoryClass
{
    public function __construct(DateOff $model)
    {
        $this->model = $model;
    }

}