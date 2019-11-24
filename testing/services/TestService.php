<?php
namespace testing\services;

use common\transactions\TransactionManager;
use olympic\repositories\OlimpicListRepository;
use testing\forms\TestCreateForm;
use testing\models\Test;
use testing\models\TestClass;
use testing\models\TestGroup;
use testing\repositories\TestClassRepository;
use testing\repositories\TestGroupRepository;
use testing\repositories\TestQuestionGroupRepository;
use testing\repositories\TestRepository;

class TestService
{
    private $repository;
    private $olympicRepository;
    private $transactionManager;
    private $classRepository;
    private $groupRepository;
    private $testQuestionGroupRepository;

    public function __construct(TestRepository $repository,
                                OlimpicListRepository $olympicRepository,
                                TransactionManager $transactionManager,
                                TestClassRepository $classRepository,
                                TestGroupRepository $groupRepository,
                                TestQuestionGroupRepository $testQuestionGroupRepository)
    {
        $this->repository = $repository;
        $this->olympicRepository = $olympicRepository;
        $this->transactionManager = $transactionManager;
        $this->classRepository = $classRepository;
        $this->groupRepository = $groupRepository;
        $this->testQuestionGroupRepository = $testQuestionGroupRepository;
    }

    public function create(TestCreateForm $form)
    {
        $olympic = $this->olympicRepository->get($form->olimpic_id);
        $model = Test::create($form, $olympic->id);
        $this->transactionManager->wrap(function () use ($model, $form, $olympic) {
            $this->repository->save($model);
            if ($form->classesList) {
                foreach($form->classesList as $class) {
                    $this->repository->isTestClass($olympic->id, $class);
                    $classTest = TestClass::create($model->id, $class);
                    $this->classRepository->save($classTest);
                }
            }
            if ($form->questionGroupsList) {
                foreach($form->questionGroupsList as $questionGroup) {
                    $this->testQuestionGroupRepository->getIdAndOlympic($questionGroup, $olympic->olimpic_id);
                    $testGroup = TestGroup::create($model->id, $questionGroup);
                    $this->groupRepository->save($testGroup);
                }
            }
        });

        return $model;
    }

    public function edit(TestEditForm $form)
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