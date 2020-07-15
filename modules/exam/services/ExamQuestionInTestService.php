<?php
namespace modules\exam\services;

use common\helpers\FlashMessages;
use common\transactions\TransactionManager;
use modules\exam\forms\ExamQuestionGroupForm;
use modules\exam\forms\ExamQuestionInTestForm;
use modules\exam\forms\ExamQuestionInTestTableMarkForm;
use modules\exam\models\ExamQuestionGroup;
use modules\exam\models\ExamQuestionInTest;
use modules\exam\repositories\ExamQuestionGroupRepository;
use modules\exam\repositories\ExamQuestionInTestRepository;
use modules\exam\repositories\ExamQuestionRepository;
use modules\exam\repositories\ExamTestRepository;
use testing\helpers\TestAndQuestionsHelper;
use function GuzzleHttp\Promise\all;

class ExamQuestionInTestService
{
    private $repository;
    private $testRepository;
    private $questionGroupRepository;
    private $questionRepository;
    private $transactionManager;

    public function __construct(ExamQuestionInTestRepository $repository,
                                ExamTestRepository $testRepository,
                                ExamQuestionGroupRepository $questionGroupRepository,
                                ExamQuestionRepository $questionRepository,
                                TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->testRepository = $testRepository;
        $this->questionGroupRepository = $questionGroupRepository;
        $this->questionRepository = $questionRepository;
        $this->transactionManager = $transactionManager;
    }

    public function addQuestions(ExamQuestionInTestForm $form): void
    {
        $test = $this->testRepository->get($form->test_id);
        foreach ($form->question_id as $question_id) {
            $question = $this->questionRepository->get($question_id);
            if ($this->repository->isQuestionInTest($test->id, $question->id)) {
                throw new \DomainException('Вопрос  "'. $question->title . '" уже используется');
                continue;
            }
            $exam = ExamQuestionInTest::create(null, $question->id, $test->id);
            $this->repository->save($exam);
        }
    }

    public function addGroup(ExamQuestionInTestForm $form): void
    {
        $test = $this->testRepository->get($form->test_id);
        foreach ($form->question_group_id as $group_id) {
            $question_group_id = $this->questionGroupRepository->get($group_id);
            if ($this->repository->isQuestionGroupInTest($test->id, $question_group_id->id)) {
                throw new \DomainException('Группа вопросов  "'. $question_group_id->name . '" уже используется');
                continue;
            }
            $exam = ExamQuestionInTest::create($question_group_id->id, null, $test->id);
            $this->repository->save($exam);
        }
    }

    public function addMark(ExamQuestionInTestTableMarkForm $form): void
    {
        $markSum = array_sum(array_map(function($mark) { return $mark['mark']; }, $form->arrayMark));

        if ($markSum > TestAndQuestionsHelper::MARK_SUM_TEST) {
            throw new \DomainException(FlashMessages::get()["sumMushMark"]);
        }
        foreach ($form->arrayMark as $mark) {
            $testAndQuestion = $this->repository->get($mark->id);
            $this->isTestActive($testAndQuestion->test_id, FlashMessages::get()["activeTest"]);
            $testAndQuestion->addMark($mark->mark);
            $this->repository->save($testAndQuestion);
        }
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->isTestActive($model->test_id, FlashMessages::get()["activeTestActionDelete"]);
        $this->repository->remove($model);
    }

    private function isTestActive($test_id,  $message) {
        if ($this->testRepository->get($test_id)->active()) {
            throw new \DomainException($message);
        }
    }

}