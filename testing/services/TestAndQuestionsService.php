<?php
namespace testing\services;


use common\transactions\TransactionManager;
use testing\forms\TestAndQuestionsForm;
use testing\models\TestAndQuestions;
use testing\repositories\TestAndQuestionsRepository;
use testing\repositories\TestGroupRepository;
use testing\repositories\TestQuestionRepository;
use testing\repositories\TestRepository;

class TestAndQuestionsService
{
    private $repository;
    private $testGroupRepository;
    private $testRepository;
    private $questionRepository;
    private $transactionManager;

    public function __construct(TestAndQuestionsRepository $repository,
                                TestGroupRepository $testGroupRepository,
                                TestRepository $testRepository,
                                TestQuestionRepository $questionRepository,
                                TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->questionRepository = $questionRepository;
        $this->testGroupRepository = $testGroupRepository;
        $this->testRepository = $testRepository;
        $this->transactionManager = $transactionManager;
    }

    public function addQuestions(TestAndQuestionsForm $form): void
    {
        $test = $this->testRepository->get($form->test_id);
        $question = $this->questionRepository->get($form->question_id);
        $testAndQuestion = TestAndQuestions::create(null, $question->id, $test->id);
        $this->repository->save($testAndQuestion);
    }

    public function addGroup(TestAndQuestionsForm $form): void
    {
        $test = $this->testRepository->get($form->test_id);
        $test_group = $this->testGroupRepository->get($form->test_group_id);
        $testAndQuestion = TestAndQuestions::create($test_group->id, null, $test->id);
        $this->repository->save($testAndQuestion);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}