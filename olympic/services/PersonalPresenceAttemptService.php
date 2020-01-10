<?php


namespace olympic\services;

use olympic\helpers\OlympicHelper;
use olympic\helpers\OlympicNominationHelper;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\Diploma;
use olympic\models\PersonalPresenceAttempt;
use olympic\models\UserOlimpiads;
use olympic\repositories\DiplomaRepository;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\OlimpicNominationRepository;
use olympic\repositories\PersonalPresenceAttemptRepository;
use testing\forms\AddFinalMarkTableForm;
use testing\models\TestAttempt;

class PersonalPresenceAttemptService
{
    private $repository;
    private $olimpicListRepository;
    private $olimpicNominationRepository;
    private $diplomaRepository;
    public function __construct(PersonalPresenceAttemptRepository $repository,
                                OlimpicListRepository $olimpicListRepository,
                                OlimpicNominationRepository $olimpicNominationRepository, DiplomaRepository $diplomaRepository)
    {
        $this->olimpicListRepository = $olimpicListRepository;
        $this->repository= $repository;
        $this->olimpicNominationRepository = $olimpicNominationRepository;
        $this->diplomaRepository = $diplomaRepository;
    }

    public function createMark(AddFinalMarkTableForm $form) {
        foreach ($form->arrayMark as $mark) {
            $ppa = $this->repository->get($mark->id);
            $ppa->setMark($mark->mark);
            $this->repository->save($ppa);
        }
    }

    public function finish($olympic_id) {
        $olympic= $this->olimpicListRepository->isFinishDateRegister($olympic_id);
        if(!$this->isCorrectCountPresenceStatus($olympic->id)) {
            throw new \DomainException("Не всем учатсникам поставлены явки/неявки");
        }
        elseif($this->countIncomingPresenceTour($olympic_id))
        {
            throw  new \DomainException("Количество присутствующих участников меньше 10. Если это действительно так, 
            то сообщите, о несостоявшейся олимпиаде аднимистраторам портала");
        }
        elseif(!$this->isCorrectCountPresenceStatusAndIsMark($olympic->id)) {
            throw new \DomainException("Поставьте оценки участникам");
        }
        elseif(!$this->isRewardStatus($olympic->id)) {
            throw new \DomainException("Поставьте все призовые места участникам");
        }
        elseif(!$this->isMaxMarkOnFirstPlace($olympic->id)) {
            throw new \DomainException("Участник, который получил максимальный балл, не указан как победитель");
        }
        elseif(!$this->isCorrectCountNomination($olympic->id)) {
            throw new \DomainException("Отметьте номинации");
        }
        else {
            $rewardUser = PersonalPresenceAttempt::find()->olympic($olympic->id)->isNotNullRewards()->all();
            if (!Diploma::find()->olympic($olympic->id)->exists()) {
                foreach ($rewardUser as $eachUser) {
                    $diploma= Diploma::create($eachUser->user_id, $olympic->id, $eachUser->reward_status, $eachUser->nomination_id);
                    $this->diplomaRepository->save($diploma);
                }
            }

           $olympic->current_status = OlympicHelper::OCH_FINISH;
           $this->olimpicListRepository->save($olympic);
        }
    }

    public function appeal($olympic_id) {
        $olympic= $this->olimpicListRepository->isFinishDateRegister($olympic_id);
        if(!$olympic->isAppeal()) {
            throw new \DomainException("Для данной олмпиады аппеляция не прудусмотрена");
        }
        $olympic->current_status = OlympicHelper::APPELLATION;
        $this->olimpicListRepository->save($olympic);
    }

    public function create($olympic_id) {
        $olympic= $this->olimpicListRepository->isFinishDateRegister($olympic_id);
        if ($olympic->isTimeStartTour()) {
            if ($olympic->isFormOfPassageInternal()) {
                $uo = UserOlimpiads::find()->select('user_id')->andWhere(['olympiads_id' => $olympic->id]);
                $uoClone = clone $uo;
                if (!$uo) {
                    throw new \DomainException("Ведомость не может создана, так как нет ни одного участника олимпиады");
                }
                if ($uoClone->count() < OlympicHelper::COUNT_USER_OCH) {
                    throw new \DomainException("Ведомость не может создана, так как участников олимпдаы меньше ". OlympicHelper::COUNT_USER_OCH);
                }
                foreach ($uo->all() as $u) {
                    if ($this->repository->getUser($olympic->id, $u->user_id)){
                        continue;
                    }
                    $attempt = PersonalPresenceAttempt::defaultCreate($u->user_id, $olympic->id);
                  $this->repository->save($attempt);
                }
            }
            else if ($olympic->isFormOfPassageDistantInternal()) {
                $uo =  TestAttempt::find()->inTestIdOlympic($olympic)->isNotNullMark()->orderByMark();
                $uoClone = clone $uo;
                if (!$uo) {
                    throw new \DomainException("Ведомость не может создана, так как нет ни одного участника");
                }

//                if ($uoClone->count() < OlympicHelper::COUNT_USER_ZAOCH) {
//                    throw new \DomainException("Ведомость не может создана, так как участников олимпдаы, прошедших заочного тура,  меньше ". OlympicHelper::COUNT_USER_ZAOCH);
//                }

                if (!$olympic->isPercentToCalculate()) {
                    throw new \DomainException('На данной олимпиаде отсутвует "Процент участников в следующий тур".
                     Обратитесь к администраторам портала');
                }

                $countUser = round(($uoClone->count()*$olympic->isPercentToCalculate())/100);

                foreach ($uo->limit($countUser)->all() as $u) {
                    if ($this->repository->getUser($olympic->id, $u->user_id)){
                        continue;
                    }
                    $attempt = PersonalPresenceAttempt::defaultCreate($u->user_id, $olympic->id);
                    $this->repository->save($attempt);

                }

                $olympic->current_status = OlympicHelper::ZAOCH_FINISH;
                $this->olimpicListRepository->save($olympic);
            }
        }
        else {
            throw new \DomainException("Для данной олимпиады очная ведомость непредусмотрена!");
        }
        return $olympic;
    }

    public function deleteMark($id) {
        $ppa = $this->repository->get($id);
        $ppa = $this->nullValue($ppa);
        $this->repository->save($ppa);
    }

    public function nomination($id, $nomination)
    {
        $nomination = $this->olimpicNominationRepository->get($nomination);
        $ppa = $this->repository->get($id);
        $this->repository->getNomination($ppa->olimpic_id, $nomination->id);
        $ppa->setNomination($nomination->id);
        $ppa->setRewardStatus(PersonalPresenceAttemptHelper::NOMINATION);
        $this->repository->save($ppa);
    }

    public function rewardStatus($id, $status) {
        $ppa = $this->repository->get($id);
        $ppa->setRewardStatus($status);
        $ppa->setNomination(null);
        $this->repository->save($ppa);
    }

    public function presenceStatus($id, $status) {
        $ppa = $this->repository->get($id);
        $ppa = $this->nullValue($ppa);
        $ppa->setPresenceStatus($status);
        $this->repository->save($ppa);
    }

    public function removeAllStatuses($id) {
        $ppa = $this->repository->get($id);
        $ppa->setNomination(null);
        $ppa->setRewardStatus(null);
        $this->repository->save($ppa);
    }

    private function nullValue (PersonalPresenceAttempt $presenceAttempt) {
        $presenceAttempt->setMark(null);
        $presenceAttempt->setNomination(null);
        $presenceAttempt->setRewardStatus(null);
        return $presenceAttempt;
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

    private function countIncomingPresenceTour($olympic_id)
    {
        return PersonalPresenceAttempt::find()->olympic($olympic_id)->presence()->count() < OlympicHelper::COUNT_USER_OCH;

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