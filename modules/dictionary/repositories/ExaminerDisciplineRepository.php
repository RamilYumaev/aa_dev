<?php


namespace modules\dictionary\repositories;


use modules\dictionary\models\ExaminerDiscipline;
use modules\usecase\RepositoryClass;

class ExaminerDisciplineRepository extends RepositoryClass
{
    public function __construct(ExaminerDiscipline $model)
    {
        $this->model = $model;
    }

}