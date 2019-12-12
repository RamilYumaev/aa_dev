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
use testing\repositories\TestClassRepository;
use testing\repositories\TestGroupRepository;
use testing\repositories\TestQuestionGroupRepository;
use testing\repositories\TestRepository;
use testing\repositories\TestResultRepository;

class TestResultService
{
    private $repository;


    public function __construct(TestResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($attempt_id, $question_id, $tq_id,  AddFinalMarkResultForm $form)
    {
        $res = $this->repository->get($attempt_id, $question_id, $tq_id);
        $res->setMark($form->mark);
        $this->repository->save($res);
    }

}