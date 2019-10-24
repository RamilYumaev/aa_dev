<?php
namespace olympic\services\dictionary;

use olympic\forms\dictionary\CategoryDocForm;
use olympic\models\dictionary\CategoryDoc;
use olympic\repositories\dictionary\CategoryDocRepository;

class CategoryDocService
{
    private $repository;

    public function __construct(CategoryDocRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CategoryDocForm $form) {
        $model = CategoryDoc::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, CategoryDocForm $form) {
        $model = $this->repository->get($id);
        $model->edit($form);
        $this->repository->save($model);
    }

    public function remove($id) {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}