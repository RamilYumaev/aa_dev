<?php


namespace modules\management\services;


use modules\management\models\CategoryDocument;
use modules\management\repositories\CategoryDocumentRepository;
use modules\usecase\ServicesClass;


class CategoryDocumentService extends ServicesClass
{

    public function __construct(CategoryDocumentRepository $repository, CategoryDocument $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

}