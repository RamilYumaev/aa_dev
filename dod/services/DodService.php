<?php


namespace dod\services;

use dictionary\repositories\FacultyRepository;
use dod\forms\DodCreateForm;
use dod\forms\DodEditForm;
use dod\models\Dod;
use dod\repositories\DodRepository;

class DodService
{
    private $repository;
    private $facultyRepository;

    public function __construct(DodRepository $repository, FacultyRepository $facultyRepository)
    {
        $this->repository = $repository;
        $this->facultyRepository = $facultyRepository;
    }

    public function create(DodCreateForm $form)
    {
        if (!$form->type) {
            $facult = $this->facultyRepository->get($form->faculty_id);
        }
        $model = Dod::create($form, !$form->type ? $facult->id : null);
        $this->repository->save($model);
        return $model;
    }

    public function edit(DodEditForm $form)
    {
        if (!$form->type) {
            $facult = $this->facultyRepository->get($form->faculty_id);
        }
        $model = $this->repository->get($form->_dod->id);
        $model->edit($form, !$form->type ? $facult->id : null);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}