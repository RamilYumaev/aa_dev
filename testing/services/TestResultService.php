<?php
namespace testing\services;

use common\helpers\FlashMessages;
use common\transactions\TransactionManager;
use olympic\repositories\OlimpicListRepository;
use testing\forms\AddFinalMarkResultForm;
use testing\forms\TestCreateForm;
use testing\forms\TestEditForm;
use testing\helpers\TestAndQuestionsHelper;
use testing\helpers\TestHelper;
use testing\models\Test;
use testing\models\TestClass;
use testing\models\TestGroup;
use testing\models\TestResult;
use testing\repositories\TestAttemptRepository;
use testing\repositories\TestClassRepository;
use testing\repositories\TestGroupRepository;
use testing\repositories\TestQuestionGroupRepository;
use testing\repositories\TestRepository;
use testing\repositories\TestResultRepository;

class TestResultService
{
    private $repository;
    private $testAttemptRepository;
    private $transactionManager;


    public function __construct(TestResultRepository $repository,
                                TestAttemptRepository $testAttemptRepository,
                                TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->testAttemptRepository = $testAttemptRepository;
        $this->transactionManager = $transactionManager;
    }

    public function create($attempt_id, $question_id, $tq_id,  AddFinalMarkResultForm $form)
    {
        $res = $this->repository->get($attempt_id, $question_id, $tq_id);
        $this->transactionManager->wrap(function () use ($res, $form){
            $res->setMark($form->mark);
            $this->repository->save($res);
            $testAttempt = $this->testAttemptRepository->get($res->attempt_id);
            $testResult  = TestResult::find()->where(['attempt_id'=>$testAttempt->id])->sum('mark');
            $testAttempt->edit($testResult);
            $this->testAttemptRepository->save($testAttempt);
        });
    }

}