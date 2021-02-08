<?php


namespace modules\management\services;


use modules\management\models\PostManagement;
use modules\management\repositories\PostManagementRepository;
use modules\usecase\ServicesClass;


class PostManagementService extends ServicesClass
{

    public function __construct(PostManagementRepository $repository, PostManagement $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}