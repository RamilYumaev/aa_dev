<?php


namespace modules\dictionary\services;

use modules\usecase\ServicesClass;
use modules\dictionary\forms\DictForeignLanguageForm;
use modules\dictionary\models\DictForeignLanguage;
use modules\dictionary\repositories\DictForeignLanguageRepository;

class DictForeignLanguageService extends ServicesClass
{

    public function __construct(DictForeignLanguageRepository $repository, DictForeignLanguage $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}