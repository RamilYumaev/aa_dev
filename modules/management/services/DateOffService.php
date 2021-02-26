<?php


namespace modules\management\services;


use modules\management\models\DateOff;
use modules\management\repositories\DateOffRepository;
use modules\usecase\ServicesClass;


class DateOffService extends ServicesClass
{

    public function __construct(DateOffRepository $repository, DateOff $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    public function allowed($id, $is)
    {
        $model = $this->repository->get($id);
        $model->setIsAllowed($is);
        $this->repository->save($model);
    }

}