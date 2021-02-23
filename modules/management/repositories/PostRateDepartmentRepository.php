<?php


namespace modules\management\repositories;

use modules\management\models\PostRateDepartment;
use modules\usecase\RepositoryClass;

class PostRateDepartmentRepository extends RepositoryClass
{
    public function __construct(PostRateDepartment $model)
    {
        $this->model = $model;
    }

}