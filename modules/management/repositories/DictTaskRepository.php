<?php


namespace modules\management\repositories;


use modules\management\models\DictTask;
use modules\usecase\RepositoryClass;

class DictTaskRepository extends RepositoryClass
{
    public function __construct(DictTask $model)
    {
        $this->model = $model;
    }

}