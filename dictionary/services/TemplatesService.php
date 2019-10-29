<?php


namespace dictionary\services;


use dictionary\forms\TemplatesCreateForm;
use dictionary\forms\TemplatesEditForm;
use dictionary\models\Templates;
use dictionary\repositories\TemplatesRepository;

class TemplatesService
{
    private $repository;

    public function __construct(TemplatesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(TemplatesCreateForm $form)
    {
        $model = Templates::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit(TemplatesEditForm $form)
    {
        $model = $this->repository->get($form->_templates->id);
        $model->edit($form);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}