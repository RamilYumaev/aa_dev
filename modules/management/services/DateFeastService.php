<?php


namespace modules\management\services;


use modules\management\models\DateFeast;
use modules\management\repositories\DateFeastRepository;
use modules\usecase\ServicesClass;


class DateFeastService extends ServicesClass
{

    public function __construct(DateFeastRepository $repository, DateFeast $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}