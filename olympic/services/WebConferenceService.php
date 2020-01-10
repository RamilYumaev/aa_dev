<?php

namespace olympic\services;

use olympic\forms\WebConferenceForm;
use olympic\models\WebConference;
use olympic\repositories\WebConferenceRepository;

class WebConferenceService
{
    private $repository;

    public function __construct(WebConferenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(WebConferenceForm $form)
    {
        $model = WebConference::create($form->name, $form->link);
        $this->repository->save($model);
    }

    public function edit($id, WebConferenceForm $form)
    {
        $model = $this->repository->get($id);
        $model->edit($form->name, $form->link);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}