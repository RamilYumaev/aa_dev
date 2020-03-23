<?php


namespace modules\dictionary\services;


use modules\dictionary\forms\DictCategoryForm;
use modules\dictionary\models\DictCategory;
use modules\dictionary\repositories\DictCategoryRepository;

class DictCategoryService
{
    private $repository;

    public function __construct(DictCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictCategoryForm $form)
    {
        $model = DictCategory::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, DictCategoryForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}