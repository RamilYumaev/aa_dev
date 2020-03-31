<?php


namespace modules\dictionary\services;


use modules\dictionary\models\DictOrganizations;
use modules\dictionary\repositories\DictOrganizationsRepository;
use modules\usecase\ServicesClass;


class DictOrganizationService extends ServicesClass
{

    public function __construct(DictOrganizationsRepository $repository, DictOrganizations $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }


}