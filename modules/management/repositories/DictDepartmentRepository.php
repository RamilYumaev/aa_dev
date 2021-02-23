<?php


namespace modules\management\repositories;


use modules\management\models\DictDepartment;
use modules\usecase\RepositoryClass;

class DictDepartmentRepository extends RepositoryClass
{
    public function __construct(DictDepartment $model)
    {
        $this->model = $model;
    }

}