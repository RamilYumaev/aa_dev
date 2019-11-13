<?php


namespace olympic\services;

use olympic\forms\OlimpicNominationCreateForm;
use olympic\forms\OlimpicNominationEditForm;
use olympic\models\OlimpicNomination;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\OlimpicNominationRepository;

class OlimpicNominationService
{
    private $repository;
    private $olimpicListRepository;

    public function __construct(OlimpicNominationRepository $repository, OlimpicListRepository $olimpicListRepository)
    {
        $this->repository = $repository;
        $this->olimpicListRepository = $olimpicListRepository;
    }

    public function create(OlimpicNominationCreateForm $form)
    {
        $olympic = $this->olimpicListRepository->get($form->olimpic_id);
        $model = OlimpicNomination::create($olympic->id, $form->name);
        $this->repository->save($model);
        return $model;
    }

    public function edit(OlimpicNominationEditForm $form)
    {
        $model = $this->repository->get($form->_olympicNomination->id);
        $olympic = $this->olimpicListRepository->get($form->olimpic_id);
        $model->edit($olympic->id, $form->name);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}