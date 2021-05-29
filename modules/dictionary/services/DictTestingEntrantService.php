<?php


namespace modules\dictionary\services;


use modules\dictionary\models\DictTestingEntrant;
use modules\dictionary\repositories\DictTestingEntrantRepository;
use modules\usecase\ServicesClass;


class DictTestingEntrantService extends ServicesClass
{

    public function __construct(DictTestingEntrantRepository $repository, DictTestingEntrant $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}