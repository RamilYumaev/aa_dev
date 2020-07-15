<?php


namespace modules\dictionary\repositories;


use modules\dictionary\models\DictExaminer;
use modules\usecase\RepositoryClass;

class DictExaminerRepository extends RepositoryClass
{
    public function __construct(DictExaminer $model)
    {
        $this->model = $model;
    }

}