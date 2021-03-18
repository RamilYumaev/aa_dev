<?php

namespace modules\management\repositories;
use modules\management\models\DocumentTask;
use modules\usecase\RepositoryClass;

class DocumentTaskRepository extends RepositoryClass
{
    public function __construct(DocumentTask $model)
    {
        $this->model = $model;
    }
}