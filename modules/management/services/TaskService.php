<?php


namespace modules\management\services;


use modules\management\models\Task;
use modules\management\repositories\TaskRepository;
use modules\usecase\ServicesClass;


class TaskService extends ServicesClass
{

    public function __construct(TaskRepository $repository, Task $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}