<?php


namespace modules\dictionary\repositories;


use modules\dictionary\models\DictTestingEntrant;
use modules\usecase\RepositoryClass;

class DictTestingEntrantRepository extends RepositoryClass
{
    public function __construct(DictTestingEntrant $model)
    {
        $this->model = $model;
    }
}