<?php


namespace modules\dictionary\repositories;

use modules\dictionary\models\DictCathedra;
use modules\dictionary\models\DictCtSubject;
use modules\dictionary\models\DictForeignLanguage;
use modules\usecase\RepositoryClass;

class DictCtSubjectRepository extends RepositoryClass
{

    public function __construct(DictCtSubject $model)
    {
        $this->model = $model;
    }

}