<?php


namespace modules\dictionary\services;

use modules\dictionary\models\DictCathedra;
use modules\dictionary\repositories\DictCathedraRepository;
use modules\usecase\ServicesClass;

class DictCathedraService extends ServicesClass
{

    public function __construct(DictCathedraRepository $repository, DictCathedra $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}