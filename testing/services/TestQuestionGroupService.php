<?php
namespace testing\services;

use olympic\models\OlimpicList;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\OlympicRepository;
use testing\forms\TestQuestionGroupCreateForm;
use testing\forms\TestQuestionGroupEditForm;
use testing\models\TestQuestionGroup;
use testing\repositories\TestQuestionGroupRepository;

class TestQuestionGroupService
{
    private $repository;
    private $olympicRepository;

    public function __construct(TestQuestionGroupRepository $repository,OlympicRepository $olympicRepository)
    {
        $this->repository = $repository;
        $this->olympicRepository = $olympicRepository;
    }

    public function create(TestQuestionGroupCreateForm $form)
    {
        $olympic = $this->olympicRepository->get($form->olimpic_id);
        $model = TestQuestionGroup::create($olympic->id, $form);
        $this->repository->save($model);
        return $model;
    }

    public function edit(TestQuestionGroupEditForm $form)
    {
        $olympic = $this->olympicRepository->get($form->olimpic_id);
        $model = $this->repository->get($form->_questionGroup->id);
        $model->edit($olympic->id, $form);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}