<?php

namespace modules\management\repositories;
use modules\management\models\CommentTask;
use modules\usecase\RepositoryClass;

class CommentTaskRepository extends RepositoryClass
{
    public function __construct(CommentTask $model)
    {
        $this->model = $model;
    }
}