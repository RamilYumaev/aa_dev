<?php


namespace modules\management\services;


use modules\management\models\RegistryDocument;
use modules\management\repositories\RegistryDocumentRepository;
use modules\usecase\ServicesClass;


class RegistryDocumentService extends ServicesClass
{

    public function __construct(RegistryDocumentRepository $repository, RegistryDocument $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}