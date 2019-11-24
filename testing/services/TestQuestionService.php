<?php
namespace testing\services;

use common\transactions\TransactionManager;
use olympic\repositories\OlimpicListRepository;
use testing\forms\question\TestQuestionForm;
use testing\forms\question\TestQuestionTypesFileForm;
use testing\forms\question\TestQuestionTypesForm;
use testing\forms\TestCreateForm;
use testing\helpers\TestQuestionGroupHelper;
use testing\models\Test;
use testing\models\TestQuestion;
use testing\repositories\TestClassRepository;
use testing\repositories\TestGroupRepository;
use testing\repositories\TestQuestionGroupRepository;
use testing\repositories\TestQuestionRepository;
use testing\repositories\TestRepository;
use yii\helpers\Json;

class TestQuestionService
{
    private $repository;
    private $groupRepository;

    public function __construct(TestQuestionRepository $repository, TestQuestionGroupRepository $groupRepository)
    {
        $this->repository = $repository;
        $this->groupRepository = $groupRepository;
    }

    public function create(TestQuestionTypesForm $form)
    {
        $group_id = $this->isGroupQuestionId($form->question->group_id);
        $options =  Json::encode($form->selectAnswer);
        $model = TestQuestion::create($form->question, $group_id, null, $options);
        $this->repository->save($model);
        return $model;
    }

    public function createQuestion(TestQuestionForm $form)
    {
        $group_id = $this->isGroupQuestionId($form->group_id);
        $model = TestQuestion::create($form, $group_id, null, null);
        $this->repository->save($model);
        return $model;
    }

    public function createTypeFile(TestQuestionTypesFileForm $form)
    {
        $group_id = $this->isGroupQuestionId($form->question->group_id);
        $model = TestQuestion::create($form->question, $group_id, $form->file_type_id, null);
        $this->repository->save($model);
        return $model;
    }

    private function isGroupQuestionId($group_id) {
        $group = $this->groupRepository->getIs($group_id);
        return $group->id ?? null;
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}