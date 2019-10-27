<?php
namespace dictionary\services;

use dictionary\forms\DictSchoolsForm;
use dictionary\models\DictSchools;
use dictionary\repositories\DictSchoolsRepository;

class DictSchoolsService
{
    private $repository;

    public function __construct(DictSchoolsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictSchoolsForm $form)
    {
        $model = DictSchools::create($form);
        $this->repository->save($model);
    }

    public function edit($id, DictSchoolsForm $form)
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