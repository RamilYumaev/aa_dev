<?php


namespace modules\management\repositories;


use modules\management\models\PostManagement;
use modules\usecase\RepositoryClass;

class PostManagementRepository extends RepositoryClass
{
    public function __construct(PostManagement $model)
    {
        $this->model = $model;
    }

}