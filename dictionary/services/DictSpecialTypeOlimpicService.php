<?php


namespace dictionary\services;


use dictionary\forms\DictSpecialTypeOlimpicCreateForm;
use dictionary\forms\DictSpecialTypeOlimpicEditForm;
use dictionary\models\DictSpecialTypeOlimpic;
use dictionary\repositories\DictSpecialTypeOlimpicRepository;

class DictSpecialTypeOlimpicService
{
    private $repository;

    public function __construct(DictSpecialTypeOlimpicRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictSpecialTypeOlimpicCreateForm $form)
    {
        $model = DictSpecialTypeOlimpic::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit(DictSpecialTypeOlimpicEditForm $form)
    {
        $model = $this->repository->get($form->_specialTypeOlimpic->id);
        $model->edit($form);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}