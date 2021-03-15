<?php


namespace modules\management\repositories;


use modules\management\models\CategoryDocument;
use modules\usecase\RepositoryClass;

class CategoryDocumentRepository extends RepositoryClass
{
    public function __construct(CategoryDocument $model)
    {
        $this->model = $model;
    }
}