<?php


namespace modules\management\services;


use modules\management\models\DictTask;
use modules\management\repositories\DictTaskRepository;
use modules\usecase\ServicesClass;


class DictTaskService extends ServicesClass
{

    public function __construct(DictTaskRepository $repository, DictTask $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}