<?php
namespace testing\services;

use common\helpers\FlashMessages;
use common\transactions\TransactionManager;
use olympic\repositories\OlimpicListRepository;
use testing\forms\TestCreateForm;
use testing\forms\TestEditForm;
use testing\helpers\TestAndQuestionsHelper;
use testing\helpers\TestHelper;
use testing\models\Test;
use testing\models\TestClass;
use testing\models\TestGroup;
use testing\repositories\TestAttemptRepository;
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
    private $testAttemptRepository;

    public function __construct(TestRepository $repository,
                                OlimpicListRepository $olympicRepository,
                                TransactionManager $transactionManager,
                                TestAttemptRepository $testAttemptRepository,
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
        $this->testAttemptRepository = $testAttemptRepository;
    }

    public function create(TestCreateForm $form)
    {
        $olympic = $this->olympicRepository->get($form->olimpic_id);
        $model = Test::create($form, $olympic->id);
        $this->transactionManager->wrap(function () use ($model, $form, $olympic) {
            $this->repository->save($model);
            if ($form->classesList) {
                foreach($form->classesList as $class) {
                    $this->repository->isTestClass($olympic->id, $class, $form->olympic_profile_id);
                    $classTest = TestClass::create($model->id, $class);
                    $this->classRepository->save($classTest);
                }
            }
        });

        return $model;
    }

    public function edit(TestEditForm $form)
    {
        $olympic = $this->olympicRepository->get($form->olimpic_id);
        $model = $this->repository->get($form->test->id);
        $this->transactionManager->wrap(function () use ($model, $form, $olympic) {
            $model->edit($form, $olympic->id);
            TestClass::deleteAll(['test_id' => $model->id]);
            if ($form->classesList) {
                foreach($form->classesList as $class) {
                    $this->repository->isTestClass($olympic->id, $class, $form->olympic_profile_id);
                    $classTest = TestClass::create($model->id, $class);
                    $this->classRepository->save($classTest);
                }
            }
            $this->repository->save($model);
        });
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        if($this->testAttemptRepository->isAttemptTest($model->id)) {
            throw new \DomainException('Вы не можете удалить данный тест, так как имеются попытки');
        }
        $this->repository->remove($model);
    }

    public function start($id)
    {
        $model = $this->repository->get($id);
        if (!TestAndQuestionsHelper::countQuestions($model->id)) {
            throw new \DomainException(FlashMessages::get()["countQuestions"]);
        }
        if (TestAndQuestionsHelper::countNullMarkQuestions($model->id)) {
        throw new \DomainException(FlashMessages::get()["countNullMarkQuestions"]);
        }

        if (!TestAndQuestionsHelper::isMarkSumSuccess($model->id)) {
            throw new \DomainException(FlashMessages::get()["sumMark"]);
        }

        $model->status = TestHelper::ACTIVE;
        $this->repository->save($model);
    }

    public function end($id)
    {
        $model = $this->repository->get($id);
        $model->status = TestHelper::DRAFT;
        $this->repository->save($model);
    }

}