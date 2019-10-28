<?php

namespace dictionary\services;

use dictionary\forms\DictSchoolsCreateForm;
use dictionary\forms\DictSchoolsEditForm;
use dictionary\models\DictSchools;
use dictionary\repositories\DictSchoolsRepository;

class DictSchoolsService
{
    private $repository;

    public function __construct(DictSchoolsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictSchoolsCreateForm $form)
    {
        $model = DictSchools::create($form);
        $this->repository->save($model);
    }

    public function edit($id, DictSchoolsEditForm $form)
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