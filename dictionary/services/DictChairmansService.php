<?php


namespace dictionary\services;


use dictionary\forms\DictChairmansCreateForm;
use dictionary\forms\DictChairmansEditForm;
use dictionary\models\DictChairmans;
use dictionary\repositories\DictChairmansRepository;

class DictChairmansService
{
    private $repository;

    public function __construct(DictChairmansRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictChairmansCreateForm $form)
    {
        $model = DictChairmans::create($form);
        if ($form->photo) {
            $model->setPhoto($form->photo);
        }
        $this->repository->save($model);
        return $model;
    }

    public function edit(DictChairmansEditForm $form)
    {
        $model = $this->repository->get($form->_dictChairmans->id);
        $model->edit($form);
        if ($form->photo) {
            $model->setPhoto($form->photo);
        }
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}