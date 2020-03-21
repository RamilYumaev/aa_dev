<?php


namespace modules\dictionary\services;

use modules\dictionary\forms\DictForeignLanguageForm;
use modules\dictionary\models\DictForeignLanguage;
use modules\dictionary\repositories\DictForeignLanguageRepository;

class DictForeignLanguageService
{
    private $repository;

    public function __construct(DictForeignLanguageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictForeignLanguageForm $form)
    {
        $model  = DictForeignLanguage::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, DictForeignLanguageForm $form)
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