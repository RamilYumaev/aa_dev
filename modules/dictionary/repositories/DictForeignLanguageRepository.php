<?php


namespace modules\dictionary\repositories;

use modules\dictionary\models\DictForeignLanguage;
use modules\usecase\RepositoryClass;

class DictForeignLanguageRepository extends RepositoryClass
{

    public function __construct(DictForeignLanguage $model)
    {
        $this->model = $model;
    }

}