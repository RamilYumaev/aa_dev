<?php


namespace modules\management\services;


use modules\management\models\DictDepartment;
use modules\management\repositories\DictDepartmentRepository;
use modules\usecase\ServicesClass;


class DictDepartmentService extends ServicesClass
{

    public function __construct(DictDepartmentRepository $repository, DictDepartment $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}