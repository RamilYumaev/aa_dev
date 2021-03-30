<?php


namespace modules\dictionary\services;

use modules\dictionary\forms\DictCseSubjectForm;
use modules\dictionary\models\DictCathedra;
use modules\dictionary\models\DictCseSubject;
use modules\dictionary\models\DictCtSubject;
use modules\dictionary\repositories\DictCathedraRepository;
use modules\dictionary\repositories\DictCseSubjectRepository;
use modules\dictionary\repositories\DictCtSubjectRepository;
use modules\usecase\ServicesClass;

class DictCtSubjectService extends ServicesClass
{

    public function __construct(DictCtSubjectRepository $repository, DictCtSubject $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }
}