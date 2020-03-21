<?php


namespace modules\entrant\services;

use modules\entrant\forms\LanguageForm;
use modules\entrant\models\Language;
use modules\entrant\repositories\LanguageRepository;

class LanguageService
{
    private $repository;

    public function __construct(LanguageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(LanguageForm $form)
    {
        $model  = Language::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, LanguageForm $form)
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