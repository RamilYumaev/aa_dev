<?php
namespace modules\exam\services;

use common\helpers\FlashMessages;
use modules\exam\forms\ExamTestForm;
use modules\exam\helpers\ExamQuestionInTestHelper;
use modules\exam\models\ExamQuestionInTest;
use modules\exam\models\ExamTest;
use modules\exam\repositories\ExamRepository;
use modules\exam\repositories\ExamTestRepository;
use testing\helpers\TestHelper;

class ExamTestService
{
    private $repository;
    private $examRepository;

    public function __construct(ExamTestRepository $repository, ExamRepository $examRepository)
    {
        $this->repository = $repository;
        $this->examRepository = $examRepository;
    }

    public function create(ExamTestForm $form)
    {
        $this->examRepository->get($form->exam_id);
        $model  = ExamTest::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, ExamTestForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        if($model->getAttempt()->count()) {
            throw new \DomainException("Вы не можете удалить тест, так как имеется попытка");
        }
        $this->repository->remove($model);
    }

    public function start($id)
    {
        $model = $this->repository->get($id);
        if (!ExamQuestionInTestHelper::countQuestions($model->id)) {
            throw new \DomainException(FlashMessages::get()["countQuestions"]);
        }
        if (ExamQuestionInTestHelper::countNullMarkQuestions($model->id)) {
            throw new \DomainException(FlashMessages::get()["countNullMarkQuestions"]);
        }

        if (!ExamQuestionInTestHelper::isMarkSumSuccess($model->id)) {
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