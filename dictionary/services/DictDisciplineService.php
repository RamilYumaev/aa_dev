<?php


namespace dictionary\services;


use dictionary\forms\DictDisciplineCreateForm;
use dictionary\forms\DictDisciplineEditForm;
use dictionary\models\DictDiscipline;
use dictionary\repositories\DictDisciplineRepository;

class DictDisciplineService
{
    private $repository;

    public function __construct(DictDisciplineRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictDisciplineCreateForm $form)
    {
        $model = DictDiscipline::create($form);
        $this->repository->save($model);
    }

    public function edit($id, DictDisciplineEditForm $form)
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