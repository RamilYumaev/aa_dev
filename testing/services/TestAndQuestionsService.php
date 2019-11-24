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

    public function create(TestAndQuestionsForm $form): void
    {
        $test = $this->testRepository->get($form->test_id);
        $test_group = $this->testGroupRepository->getIdAndTest($form->test_group_id, $test->id);
        $this->transactionManager->wrap(function () use ($form, $test, $test_group) {
            if($form->questionList) {
                foreach ($form->questionList as $question) {
                    $question = $this->questionRepository->getIdAndGroupId($question, $test_group->question_group_id);
                    $this->repository->isTestGroupQuestionTest($test->id, $question->id, $test_group->id);
                    $testAndQuestion = TestAndQuestions::create($test_group->id, $question->id, $test->id);
                    $this->repository->save($testAndQuestion);
                }
            }
        });
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}