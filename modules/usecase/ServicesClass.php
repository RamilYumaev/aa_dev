<?php

namespace modules\usecase;

use modules\dictionary\forms\DictOrganizationForm;
use phpDocumentor\Reflection\Types\Integer;
use yii\base\Model;
use yii\db\BaseActiveRecord;

class ServicesClass
{
    public $repository;
    public $model;

    public function create(Model $form)
    {
        $model  = $this->model::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, Model $form)
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