<?php
namespace testing\services;

use common\transactions\TransactionManager;
use testing\forms\question\TestQuestionForm;
use testing\forms\question\TestQuestionTypesFileForm;
use testing\forms\question\TestQuestionTypesForm;
use testing\models\Answer;
use testing\models\TestQuestion;
use testing\repositories\AnswerRepository;
use testing\repositories\TestQuestionGroupRepository;
use testing\repositories\TestQuestionRepository;

class TestQuestionService
{
    private $repository;
    private $groupRepository;
    private $transaction;
    private $answerRepository;

    public function __construct(TestQuestionRepository $repository,
                                TestQuestionGroupRepository $groupRepository,
                                TransactionManager $transaction,
                                AnswerRepository $answerRepository)
    {
        $this->repository = $repository;
        $this->groupRepository = $groupRepository;
        $this->transaction = $transaction;
        $this->answerRepository = $answerRepository;
    }

    public function create(TestQuestionTypesForm $form)
    {
        $group_id = $this->isGroupQuestionId($form->question->group_id);;

        $model = TestQuestion::create($form->question, $group_id, null, null);

        $this->transaction->wrap(function () use ($model, $form) {
            $this->repository->save($model);
            $this->addAnswer($form, $model->id);
        });
        return $model;
    }

    private function addAnswer(TestQuestionTypesForm $form, $quest_id) {
         foreach ($form->selectAnswer['text'] as $index => $answer) {
             $isCorrect = in_array($index, $form->selectAnswer['isCorrect']) ? 1 : 0;
             $answerObject = Answer::create($quest_id, $answer, $isCorrect, null);
             $this->answerRepository->save($answerObject);
         }
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