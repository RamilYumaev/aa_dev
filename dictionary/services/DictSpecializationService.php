<?php


namespace dictionary\services;


use dictionary\forms\DictSpecializationCreateForm;
use dictionary\forms\DictSpecializationEditForm;
use dictionary\models\DictSpecialization;
use dictionary\repositories\DictSpecialityRepository;
use dictionary\repositories\DictSpecializationRepository;

class DictSpecializationService
{
    private $repository;
    private $specialityRepository;

    public function __construct(DictSpecializationRepository $repository, DictSpecialityRepository $specialityRepository)
    {
        $this->repository = $repository;
        $this->specialityRepository = $specialityRepository;
    }

    public function create(DictSpecializationCreateForm $form)
    {
        $speciality = $this->specialityRepository->get($form->speciality_id);
        $model = DictSpecialization::create($form->name, $speciality->id);
        $this->repository->save($model);
    }

    public function edit($id, DictSpecializationEditForm $form)
    {
        $model = $this->repository->get($id);
        $speciality = $this->specialityRepository->get($form->speciality_id);
        $model->edit($form->name, $speciality->id);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}