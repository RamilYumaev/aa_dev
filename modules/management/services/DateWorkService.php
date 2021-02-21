<?php


namespace modules\management\services;


use modules\management\models\DateWork;
use modules\management\repositories\DateWorkRepository;
use modules\usecase\ServicesClass;


class DateWorkService extends ServicesClass
{

    public function __construct(DateWorkRepository $repository, DateWork $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}