<?php


namespace dictionary\services;


use dictionary\forms\DictSpecialityCreateForm;
use dictionary\forms\DictSpecialityEditForm;
use dictionary\models\DictSpeciality;
use dictionary\repositories\DictSpecialityRepository;

class DictSpecialityService
{
    private $repository;

    public function __construct(DictSpecialityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictSpecialityCreateForm $form)
    {
        $model = DictSpeciality::create($form);
        $this->repository->save($model);
    }

    public function edit($id, DictSpecialityEditForm $form)
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