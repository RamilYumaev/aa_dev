<?php


namespace modules\management\repositories;


use modules\management\models\Task;
use modules\usecase\RepositoryClass;

class TaskRepository extends RepositoryClass
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

}