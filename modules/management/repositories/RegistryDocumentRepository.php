<?php


namespace modules\management\repositories;


use modules\management\models\RegistryDocument;
use modules\usecase\RepositoryClass;

class RegistryDocumentRepository extends RepositoryClass
{
    public function __construct(RegistryDocument $model)
    {
        $this->model = $model;
    }
}