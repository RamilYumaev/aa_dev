<?php


namespace modules\dictionary\services;

use modules\dictionary\forms\DictCseSubjectForm;
use modules\dictionary\models\DictCseSubject;
use modules\dictionary\repositories\DictCseSubjectRepository;

class DictCseSubjectService
{
    private $repository;

    public function __construct(DictCseSubjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictCseSubjectForm $form)
    {
        $model  = DictCseSubject::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, DictCseSubjectForm $form)
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