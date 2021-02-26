<?php


namespace modules\management\repositories;


use modules\management\models\DateFeast;
use modules\usecase\RepositoryClass;

class DateFeastRepository extends RepositoryClass
{
    public function __construct(DateFeast $model)
    {
        $this->model = $model;
    }
}