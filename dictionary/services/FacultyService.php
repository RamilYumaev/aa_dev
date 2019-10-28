<?php

namespace dictionary\services;

use dictionary\forms\FacultyCreateForm;
use dictionary\forms\FacultyEditForm;
use dictionary\repositories\FacultyRepository;
use dictionary\models\Faculty;


class FacultyService
{
    private $repository;

    public function __construct(FacultyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(FacultyCreateForm $form)
    {
        $model = Faculty::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, FacultyEditForm $form)
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