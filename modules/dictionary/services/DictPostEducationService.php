<?php


namespace modules\dictionary\services;

use modules\dictionary\forms\DictPostEducationForm;
use modules\dictionary\models\DictPostEducation;
use modules\dictionary\repositories\DictPostEducationRepository;

class DictPostEducationService
{
    private $repository;

    public function __construct(DictPostEducationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictPostEducationForm $form)
    {
        $model  = DictPostEducation::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, DictPostEducationForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}