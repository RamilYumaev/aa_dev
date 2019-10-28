<?php


namespace dictionary\services;


use dictionary\forms\DictSpecializationCreateForm;
use dictionary\forms\DictSpecializationEditForm;
use dictionary\models\DictSpecialization;
use dictionary\repositories\DictSpecializationRepository;

class DictSpecializationService
{
    private $repository;

    public function __construct(DictSpecializationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictSpecializationCreateForm $form)
    {
        $model = DictSpecialization::create($form);
        $this->repository->save($model);
    }

    public function edit($id, DictSpecializationEditForm $form)
    {
        $model = $this->repository->get($id);
        $model->edit($form);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}