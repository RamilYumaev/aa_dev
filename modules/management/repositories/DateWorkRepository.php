<?php


namespace modules\management\repositories;


use modules\management\models\DateWork;
use modules\usecase\RepositoryClass;

class DateWorkRepository extends RepositoryClass
{
    public function __construct(DateWork $model)
    {
        $this->model = $model;
    }

}