<?php


namespace testing\services;


use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use olympic\models\OlimpicList;
use olympic\repositories\OlimpicListRepository;
use testing\models\TestAndQuestions;
use testing\models\TestAttempt;
use testing\models\TestQuestion;
use testing\models\TestResult;
use testing\repositories\TestAttemptRepository;
use testing\repositories\TestRepository;
use testing\repositories\TestResultRepository;
use yii\db\Expression;

class TestAttemptService
{
    private $testAttemptRepository;
    private $testRepository;
    private $testResultRepository;
    private $userRepository;
    private $transactionManager;
    private $olimpicListRepository;

    function __construct(TestRepository $testRepository,
                         TestAttemptRepository $testAttemptRepository,
                         TestResultRepository $testResultRepository,
                          UserRepository $userRepository, TransactionManager $transactionManager,
                         OlimpicListRepository $olimpicListRepository)
    {
        $this->testRepository = $testRepository;
        $this->testAttemptRepository = $testAttemptRepository;
        $this->testResultRepository = $testResultRepository;
        $this->userRepository = $userRepository;
        $this->transactionManager = $transactionManager;
        $this->olimpicListRepository = $olimpicListRepository;
    }

    public  function create($test_id) {
        $test  = $this->testRepository->isActive($test_id);
        $olympic = $this->olimpicListRepository->get($test->olimpic_id);
        $olympic->time_of_distants_tour_type;
        $testAttempt = $this->testAttemptRepository->isAttempt($test->id);
        if (!$testAttempt) {
            $testAttempt = TestAttempt::create($test_id, $olympic);
            $this->transactionManager->wrap(function () use ($testAttempt, $test){
                $this->testAttemptRepository->save($testAttempt);
                $this->randQuestions($testAttempt->id, $test->id);
            });
            return $testAttempt;
        }
        return $testAttempt;
    }

    private function randQuestions($attempt_id, $test_id) {
        $testAndQuestions = TestAndQuestions::find()->where(['test_id' => $test_id])
            ->orderBy( new Expression('rand()'))->all();
        foreach ($testAndQuestions as $index => $value) {
            if ($value->test_group_id) {
                $que = $this->randQuestionsFromGroup($value->test_group_id)->id;
            } else {
                $que = $value->question_id;
            }
            $testResult = TestResult::create($attempt_id, $que, ++$index, $value->id);
            $this->testResultRepository->save($testResult);
        }
    }

    private function randQuestionsFromGroup($group_id) {
       return $testAndQuestions = TestQuestion::find()->where(['group_id' => $group_id])
            ->orderBy( new Expression('rand()'))->one();
    }

    public  function end($test_id) {
        $test  = $this->testRepository->isActive($test_id);
        $testAttempt = $this->testAttemptRepository->isAttempt($test->id);
        $testResult  = TestResult::find()->where(['attempt_id'=>$testAttempt->id])->sum('mark');
        $testAttempt->edit($testResult);
        $this->testAttemptRepository->save($testAttempt);
        return $testAttempt;
    }
}