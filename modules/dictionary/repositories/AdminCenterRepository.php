<?php


namespace modules\dictionary\repositories;
use modules\dictionary\models\AdminCenter;
use modules\usecase\RepositoryClass;

class AdminCenterRepository extends RepositoryClass
{
    public function __construct(AdminCenter $model)
    {
        $this->model = $model;
    }
}