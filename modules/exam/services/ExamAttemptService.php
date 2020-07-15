<?php


namespace modules\exam\services;


use common\auth\repositories\UserRepository;
use common\helpers\FlashMessages;
use common\transactions\TransactionManager;
use modules\exam\helpers\ExamQuestionInTestHelper;
use modules\exam\models\ExamAttempt;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamQuestionInTest;
use modules\exam\models\ExamResult;
use modules\exam\models\ExamTest;
use modules\exam\repositories\ExamAttemptRepository;
use modules\exam\repositories\ExamResultRepository;
use modules\exam\repositories\ExamTestRepository;
use olympic\helpers\OlympicHelper;
use olympic\helpers\OlympicNominationHelper;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\Diploma;
use olympic\models\PersonalPresenceAttempt;
use olympic\repositories\DiplomaRepository;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\OlimpicNominationRepository;
use testing\helpers\TestAndQuestionsHelper;
use testing\helpers\TestAttemptHelper;
use testing\models\Test;
use testing\models\TestAndQuestions;
use testing\models\TestAttempt;
use testing\models\TestQuestion;
use testing\models\TestResult;
use testing\repositories\TestAttemptRepository;
use testing\repositories\TestRepository;
use testing\repositories\TestResultRepository;
use yii\db\Expression;

class ExamAttemptService
{
    private $testAttemptRepository;
    private $testRepository;
    private $testResultRepository;
    private $userRepository;
    private $transactionManager;
    private $olimpicListRepository;
    private $olimpicNominationRepository;
    private $diplomaRepository;

    function __construct(ExamTestRepository $testRepository,
                         ExamAttemptRepository $testAttemptRepository,
                         ExamResultRepository $testResultRepository,
                         UserRepository $userRepository, TransactionManager $transactionManager)
    {
        $this->testRepository = $testRepository;
        $this->testAttemptRepository = $testAttemptRepository;
        $this->testResultRepository = $testResultRepository;
        $this->userRepository = $userRepository;
        $this->transactionManager = $transactionManager;

    }

    public  function createDefault($test_id) {
        $test  = $this->testRepository->get($test_id);
        if (!ExamQuestionInTestHelper::countQuestions($test->id)) {
            throw new \DomainException(FlashMessages::get()["countQuestions"]);
        }
        if (ExamQuestionInTestHelper::countNullMarkQuestions($test->id)) {
            throw new \DomainException(FlashMessages::get()["countNullMarkQuestions"]);
        }
        if (!ExamQuestionInTestHelper::isMarkSumSuccess($test->id)) {
            throw new \DomainException(FlashMessages::get()["sumMark"]);
        }

        return $this->addAttempt($test);
    }

    private function addAttempt(ExamTest $test)
    {
        $testAttempt = $this->testAttemptRepository->isAttempt($test->id);
        if (!$testAttempt) {
            $testAttempt = ExamAttempt::create($test->id, $test->exam_id);
            $this->transactionManager->wrap(function () use ($testAttempt, $test){
                $this->testAttemptRepository->save($testAttempt);
                $this->randQuestions($testAttempt->id, $test->id);
            });
            return $testAttempt;
        }
        return $testAttempt;

    }



    private function randQuestions($attempt_id, $test_id) {
        $test = $this->testRepository->get($test_id);
        $testAndQuestions = ExamQuestionInTest::find()->where(['test_id' => $test->id])
            ->orderBy($test->random_order ? new Expression('rand()') : ['id'=>SORT_ASC])->all();
        foreach ($testAndQuestions as $index => $value) {
            if ($value->question_group_id) {
                $que = $this->randQuestionsFromGroup($value->question_group_id)->id;
            } else {
                $que = $value->question_id;
            }
            $examResult = ExamResult::create($attempt_id, $que, ++$index, $value->id);
            $this->testResultRepository->save($examResult);
        }
    }

    private function randQuestionsFromGroup($group_id) {

       return $testAndQuestions = ExamQuestion::find()->where(['question_group_id' => $group_id])
            ->orderBy( new Expression('rand()'))->one();
    }

    public  function end($test_id) {
        $test  = $this->testRepository->isActive($test_id);
        $testAttempt = $this->testAttemptRepository->isAttempt($test->id);
        $testResult  = TestResult::find()->where(['attempt_id'=>$testAttempt->id])->sum('mark');
        $testAttempt->seStatus(TestAttemptHelper::END_TEST);
        $testAttempt->edit($testResult);
        $this->testAttemptRepository->save($testAttempt);
        return $testAttempt;
    }

    public  function endDefault($test_id) {
        $test  = $this->testRepository->get($test_id);
        $testAttempt = $this->testAttemptRepository->isAttempt($test->id);
        $testResult  = ExamResult::find()->where(['attempt_id'=>$testAttempt->id])->sum('mark');
        $testAttempt->seStatus(TestAttemptHelper::END_TEST);
        $testAttempt->edit($testResult);
        $this->testAttemptRepository->save($testAttempt);
        return $testAttempt;
    }


    public function remove($id)
    {
        $model = $this->testAttemptRepository->get($id);
        $this->testAttemptRepository->remove($model);
    }
}