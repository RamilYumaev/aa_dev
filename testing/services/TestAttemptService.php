<?php


namespace testing\services;


use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use olympic\helpers\OlympicHelper;
use olympic\helpers\OlympicNominationHelper;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\Diploma;
use olympic\models\PersonalPresenceAttempt;
use olympic\repositories\DiplomaRepository;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\OlimpicNominationRepository;
use testing\helpers\TestAttemptHelper;
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
        $this->testAttemptRepository->getNomination($testAttempt->test_id, $nomination->id);
        $testAttempt->setNomination($nomination->id);
        $testAttempt->setRewardStatus(TestAttemptHelper::NOMINATION);
        $this->testAttemptRepository->save($testAttempt);
    }

    public function finish($olympic_id) {
        $olympic= $this->olimpicListRepository->isFinishDateRegister($olympic_id);
        if(!$this->isRewardStatus($olympic->id)) {
            throw new \DomainException("Поставьте все призовые места участникам");
        }
        elseif(!$this->isMaxMarkOnFirstPlace($olympic->id)) {
            throw new \DomainException("Участник, который получил максимальный балл, не является победителем");
        }
        elseif(!$this->isCorrectCountNomination($olympic->id)) {
            throw new \DomainException("Отметьте номминации");
        }
        else {
            $rewardUser = PersonalPresenceAttempt::find()->olympic($olympic->id)->isNotNullRewards()->all();
            if (!Diploma::find()->olympic($olympic->id)->exists()) {
                foreach ($rewardUser as $eachUser) {
                    $diploma= Diploma::create($eachUser->user_id, $olympic->id, $eachUser->reward_status, $eachUser->nomination_id);
                    $this->diplomaRepository->save($diploma);
                }
            }
            $olympic->current_status = OlympicHelper::ZAOCH_FINISH;
            $this->olimpicListRepository->save($olympic);
        }
    }

    private function countAttempt($olympic_id) {
        return PersonalPresenceAttempt::find()->olympic($olympic_id)->count();
    }

    private function countPresenceAllStatus($olympic_id) {
        return PersonalPresenceAttempt::find()->olympic($olympic_id)->andWhere(["IS NOT",'presence_status', null])->count();
    }

    private function countPresenceStatus($olympic_id) {
        return PersonalPresenceAttempt::find()->olympic($olympic_id)->presence()->count();
    }

    private function countMarkNotNull($olympic_id) {
        return PersonalPresenceAttempt::find()->olympic($olympic_id)->presence()->andWhere(["IS NOT",'mark', null])->count();
    }

    private function inRewardStatus($olympic_id, $status) {
        return PersonalPresenceAttempt::find()->olympic($olympic_id)->presence()
            ->andWhere(['reward_status'=> $status])->exists();
    }

    private function isMaxMarkOnFirstPlace($olympic_id) {
        $max = PersonalPresenceAttempt::find()->olympic($olympic_id)->max('mark');
        return PersonalPresenceAttempt::find()->olympic($olympic_id)->andWhere(['mark'=> $max])->one()->isRewardFirstPlace();
    }

    private function isCorrectCountPresenceStatus($olympic_id) {
        return $this->countAttempt($olympic_id) == $this->countPresenceAllStatus($olympic_id);
    }

    private function isCorrectCountPresenceStatusAndIsMark($olympic_id) {
        return $this->countPresenceStatus($olympic_id) == $this->countMarkNotNull($olympic_id);
    }

    private function isRewardStatus($olympic_id) {
        return $this->countPresenceStatus($olympic_id) && $this->inRewardStatus($olympic_id, PersonalPresenceAttemptHelper::FIRST_PLACE) &&
            $this->inRewardStatus($olympic_id, PersonalPresenceAttemptHelper::SECOND_PLACE)  &&
            $this->inRewardStatus($olympic_id, PersonalPresenceAttemptHelper::THIRD_PLACE);
    }

    private function isNomination($olympic_id) {
        return $this->inRewardStatus($olympic_id, PersonalPresenceAttemptHelper::NOMINATION);
    }

    private function isCorrectCountNomination($olympic_id) {
        $countNomination = OlympicNominationHelper::olympicNominationListInOlympic($olympic_id)->count();
        return $countNomination == $this->countNominationId($olympic_id);
    }

    private function countNominationId($olympic_id) {
        return PersonalPresenceAttempt::find()->olympic($olympic_id)->andWhere(["IS NOT",'nomination_id', null])->count();
    }
}