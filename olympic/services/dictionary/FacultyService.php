<?php
namespace olympic\services\dictionary;
use olympic\forms\dictionary\FacultyForm;
use olympic\repositories\dictionary\FacultyRepository;
use olympic\models\dictionary\Faculty;


class FacultyService
{
    private $repository;

    public function __construct(FacultyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(FacultyForm $form) {
        $model = Faculty::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, FacultyForm $form) {
        $model = $this->repository->get($id);
        $model->edit($form->full_name);
        $this->repository->save($model);
    }

    public function remove($id) {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}