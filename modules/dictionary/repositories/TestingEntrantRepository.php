<?php


namespace modules\dictionary\repositories;


use modules\dictionary\models\TestingEntrant;
use modules\usecase\RepositoryClass;

class TestingEntrantRepository extends RepositoryClass
{
    public function __construct(TestingEntrant $model)
    {
        $this->model = $model;
    }
}