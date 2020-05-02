<?php


namespace testing\services;


use common\auth\repositories\UserRepository;
use common\helpers\FlashMessages;
use common\transactions\TransactionManager;
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

class TestAttemptService
{
    private $testAttemptRepository;
    private $testRepository;
    private $testResultRepository;
    private $userRepository;
    private $transactionManager;
    private $olimpicListRepository;
    private $olimpicNominationRepository;
    private $diplomaRepository;

    function __construct(TestRepository $testRepository,
                         TestAttemptRepository $testAttemptRepository,
                         TestResultRepository $testResultRepository,
                         UserRepository $userRepository, TransactionManager $transactionManager,
                         OlimpicListRepository $olimpicListRepository,
                         OlimpicNominationRepository $olimpicNominationRepository,
                         DiplomaRepository $diplomaRepository)
    {
        $this->testRepository = $testRepository;
        $this->testAttemptRepository = $testAttemptRepository;
        $this->testResultRepository = $testResultRepository;
        $this->userRepository = $userRepository;
        $this->transactionManager = $transactionManager;
        $this->olimpicListRepository = $olimpicListRepository;
        $this->olimpicNominationRepository = $olimpicNominationRepository;
        $this->diplomaRepository = $diplomaRepository;

    }

    public  function createDefault($test_id) {
        $test  = $this->testRepository->get($test_id);
        if (!TestAndQuestionsHelper::countQuestions($test->id)) {
            throw new \DomainException(FlashMessages::get()["countQuestions"]);
        }
        if (TestAndQuestionsHelper::countNullMarkQuestions($test->id)) {
            throw new \DomainException(FlashMessages::get()["countNullMarkQuestions"]);
        }
        if (!TestAndQuestionsHelper::isMarkSumSuccess($test->id)) {
            throw new \DomainException(FlashMessages::get()["sumMark"]);
        }

        return $this->addAttempt($test->id, $test->olimpic_id);
    }

    private function addAttempt($test_id, $olympicId)
    {
        $olympic = $this->olimpicListRepository->get($olympicId);
        $olympic->time_of_distants_tour_type;
        $testAttempt = $this->testAttemptRepository->isAttempt($test_id);
        if (!$testAttempt) {
            $testAttempt = TestAttempt::create($test_id, $olympic);
            $this->transactionManager->wrap(function () use ($testAttempt, $test_id){
                $this->testAttemptRepository->save($testAttempt);
                $this->randQuestions($testAttempt->id, $test_id);
            });
            return $testAttempt;
        }
        return $testAttempt;

    }

    public  function create($test_id) {
        $test  = $this->testRepository->isActive($test_id);
        return $this->addAttempt($test->id, $test->olimpic_id);
    }

    private function randQuestions($attempt_id, $test_id) {
        $test = $this->testRepository->get($test_id);
        $testAndQuestions = TestAndQuestions::find()->where(['test_id' => $test->id])
            ->orderBy($test->random_order ? new Expression('rand()') : ['id'=>SORT_ASC])->all();
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
        $testAttempt->seStatus(TestAttemptHelper::END_TEST);
        $testAttempt->edit($testResult);
        $this->testAttemptRepository->save($testAttempt);
        return $testAttempt;
    }

    public  function endDefault($test_id) {
        $test  = $this->testRepository->get($test_id);
        $testAttempt = $this->testAttemptRepository->isAttempt($test->id);
        $testResult  = TestResult::find()->where(['attempt_id'=>$testAttempt->id])->sum('mark');
        $testAttempt->seStatus(TestAttemptHelper::END_TEST);
        $testAttempt->edit($testResult);
        $this->testAttemptRepository->save($testAttempt);
        return $testAttempt;
    }

    public function rewardStatus($id, $status) {
        $testAttempt = $this->testAttemptRepository->get($id);
        $testAttempt->setRewardStatus($status);
        $testAttempt->setNomination(null);
        $this->testAttemptRepository->save($testAttempt);
    }

    public function removeAllStatuses($id) {
        $testAttempt = $this->testAttemptRepository->get($id);
        $testAttempt->setNomination(null);
        $testAttempt->setRewardStatus(null);
        $this->testAttemptRepository->save($testAttempt);
    }

    public function nomination($id, $nomination)
    {
        $nomination = $this->olimpicNominationRepository->get($nomination);
        $testAttempt = $this->testAttemptRepository->get($id);
      //  $this->testAttemptRepository->getNomination($testAttempt->test_id, $nomination->id);
        $testAttempt->setNomination($nomination->id);
        $testAttempt->setRewardStatus(TestAttemptHelper::NOMINATION);
        $this->testAttemptRepository->save($testAttempt);
    }

    public function finish($test_id, $olympic_id) {
        $olympic= $this->olimpicListRepository->isFinishDateRegister($olympic_id);
        $test= $this->testRepository->get($test_id);
        if ($this->countAttempt($test->id) < OlympicHelper::COUNT_USER_ZAOCH) {
            throw  new \DomainException('Количество  участников заочного тура меньше '.OlympicHelper::COUNT_USER_ZAOCH.'. Если это действительно так,
            то сообщите, о несостоявшейся олимпиаде аднимистраторам портала');
        }
        elseif(!$this->isRewardStatus($test->id)) {
            throw new \DomainException("Поставьте все призовые места участникам");
        }
        elseif($this->countRewardStatus($test->id)  > $this->countDefaultRewards($test->id)) {
            throw new \DomainException("Число победителей и призеров (в сумме) не должно превышать 40%(".$this->countDefaultRewards($test->id).") от общего числа участников");
        }
        elseif(!$this->isCorrectCountNomination($test->id, $olympic->id)) {
            throw new \DomainException("Отметьте номминации");
        }
        elseif(!$this->isMaxMarkOnFirstPlace($test->id)) {
            throw new \DomainException("Участник, который получил максимальный балл, не является победителем/призером");
        }
        elseif($this->countRewardFirstStatus($test->id)  > $this->countDefaultRewardsFirst($test->id)) {
            throw new \DomainException("Количество победителей Мероприятия не должно превышать 10% (".$this->countDefaultRewardsFirst($test->id).") от общего количества участников");
        }
        else {
            if($olympic->isCertificate()) {
                $rewardUser =  TestAttempt::find()->test($test->id)->isNotNullMark()->all();
            }
            else {
                $rewardUser =TestAttempt::find()->test($test->id)->isNotNullRewards()->all();
            }
            if (!Diploma::find()->olympic($olympic->id)->exists()) {
                foreach ($rewardUser as $eachUser) {
                    $diploma= Diploma::create($eachUser->user_id, $olympic->id, $eachUser->reward_status, $eachUser->nomination_id);
                    $this->diplomaRepository->save($diploma);
                }
            }
            $olympic->current_status = $olympic->isNumberOfTourOne() ? OlympicHelper::OCH_FINISH : OlympicHelper::ZAOCH_FINISH;
            $this->olimpicListRepository->save($olympic);
        }
    }

    private function countAttempt($test_id) {
        return TestAttempt::find()->test($test_id)->count();
    }

    private function countAttemptNotNullMark($test_id) {
        return TestAttempt::find()->test($test_id)->isNotNullMark()->count();
    }

    private function maxMark($test_id) {
        return TestAttempt::find()->test($test_id)->max('mark');
    }

    private function countDefaultRewards($test_id) {
        return round(($this->countAttemptNotNullMark($test_id)*OlympicHelper::USER_REWARDS)/100);
    }

    private function countDefaultRewardsFirst($test_id) {
        return round(($this->countAttemptNotNullMark($test_id)*OlympicHelper::USER_REWARDS_GOLD)/100);
    }

    private function countRewardStatus($test_id) {
        return TestAttempt::find()->test($test_id)
            ->andWhere(['reward_status'=> [TestAttemptHelper::GOLD, TestAttemptHelper::BRONZE, TestAttemptHelper::SILVER]])->count();
    }

    private function countRewardFirstStatus($test_id) {
        return TestAttempt::find()->test($test_id)
            ->andWhere(['reward_status'=> TestAttemptHelper::GOLD])->count();
    }

    private function inRewardStatus($test_id, $status) {
        if($this->maxMark($test_id) < TestAttemptHelper::MIN_BALL_GOLD  && $status == TestAttemptHelper::GOLD) {
            return true;
        }
        return TestAttempt::find()->test($test_id)->andWhere(['reward_status'=> $status])->exists();
    }

    private function isMaxMarkOnFirstPlace($test_id) {
        if($this->maxMark($test_id) < TestAttemptHelper::MIN_BALL_GOLD) {
            return TestAttempt::find()->test($test_id)->andWhere(['mark'=> $this->maxMark($test_id)])->one()->isRewardNoGold();
        }
        return TestAttempt::find()->test($test_id)->andWhere(['mark'=> $this->maxMark($test_id)])->one()->isRewardGold();
    }

    private function isRewardStatus($test_id) {
        return $this->inRewardStatus($test_id, TestAttemptHelper::GOLD) &&
            $this->inRewardStatus($test_id, TestAttemptHelper::SILVER)  &&
            $this->inRewardStatus($test_id, TestAttemptHelper::BRONZE);
    }

    private function isNomination($test_id) {
        return $this->inRewardStatus($test_id, TestAttemptHelper::NOMINATION);
    }

    private function isCorrectCountNomination($test_id, $olympic_id) {
        $countNomination = OlympicNominationHelper::olympicNominationListInOlympic($olympic_id)->count();
        return $countNomination <= $this->countNominationId($test_id);
    }

    private function countNominationId($test_id) {
        return TestAttempt::find()->test($test_id)->andWhere(["IS NOT",'nomination_id', null])->count();
    }

    public function remove($id)
    {
        $model = $this->testAttemptRepository->get($id);
        $this->testAttemptRepository->remove($model);
    }
}