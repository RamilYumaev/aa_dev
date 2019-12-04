<?php
namespace testing\services;


use common\transactions\TransactionManager;
use testing\forms\TestAndQuestionsForm;
use testing\forms\TestAndQuestionsTableMarkForm;
use testing\models\TestAndQuestions;
use testing\repositories\TestAndQuestionsRepository;
use testing\repositories\TestQuestionGroupRepository;
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
                                TestQuestionGroupRepository $testGroupRepository,
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
        foreach ($form->question_id as $question_id) {
            $question = $this->questionRepository->get($question_id);
            if ($this->repository->isQuestionInTest($test->id, $question->id)) {
                throw new \DomainException('Вопрос  "'. $question->title . '" уже используется');
                continue;
            }
            $testAndQuestion = TestAndQuestions::create(null, $question->id, $test->id);
            $this->repository->save($testAndQuestion);
        }
    }

    public function addGroup(TestAndQuestionsForm $form): void
    {
        $test = $this->testRepository->get($form->test_id);
        foreach ($form->test_group_id as $test_group_id) {
            $test_group = $this->testGroupRepository->get($test_group_id);
            if ($this->repository->isTestGroupInTest($test->id, $test_group->id)) {
                throw new \DomainException('Группа вопросов  "'. $test_group->name . '" уже используется');
                continue;
            }
            $testAndQuestion = TestAndQuestions::create($test_group->id, null, $test->id);
            $this->repository->save($testAndQuestion);
        }
    }

    public function addMark(TestAndQuestionsTableMarkForm $form): void
    {
        foreach ($form->arrayMark as $mark) {
            $testAndQuestion = $this->repository->get($mark->id);
            $testAndQuestion->addMark($mark->mark);
            $this->repository->save($testAndQuestion);
        }
    }


    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}