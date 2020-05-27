<?php


namespace modules\dictionary\repositories;

use modules\dictionary\models\DictCathedra;
use modules\dictionary\models\DictForeignLanguage;
use modules\usecase\RepositoryClass;

class DictCathedraRepository extends RepositoryClass
{

    public function __construct(DictCathedra $model)
    {
        $this->model = $model;
    }

}