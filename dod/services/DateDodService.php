<?php


namespace dod\services;

use dod\forms\DateDodEditForm;
use dod\forms\DateDodCreateForm;
use dod\models\DateDod;
use dod\repositories\DodRepository;
use dod\repositories\DateDodRepository;

class DateDodService
{
    private $repository;
    private $dodRepository;

    public function __construct(DateDodRepository $repository, DodRepository $dodRepository)
    {
        $this->repository = $repository;
        $this->dodRepository  = $dodRepository;
    }

    public function create(DateDodCreateForm$form)
    {
        $dod = $this->dodRepository->get($form->dod_id);
        $model = DateDod::create($form,$dod->id);
        $this->repository->save($model);
        return $model;
    }

    public function edit(DateDodEditForm $form)
    {
        $dod = $this->dodRepository->get($form->dod_id);
        $model = $this->repository->get($form->_dateDod->id);
        $model->edit($form, $dod->id);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}