<?php

namespace common\sending\services;

use common\auth\repositories\UserRepository;
use common\sending\helpers\DictSendingTemplateHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\helpers\SendingHelper;
use common\sending\models\Sending;
use common\sending\repositories\SendingDeliveryStatusRepository;
use common\sending\repositories\SendingRepository;
use common\sending\traits\MailTrait;
use common\sending\traits\SelectionCommitteeMailTrait;
use common\transactions\TransactionManager;
use dod\models\DateDod;
use dod\models\UserDod;
use dod\readRepositories\DateDodReadRepository;
use dod\repositories\DateDodRepository;
use dod\repositories\UserDodRepository;
use olympic\models\Diploma;
use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;
use olympic\models\UserOlimpiads;
use olympic\repositories\OlimpicListRepository;

class SendingDodProcessService
{
    private  $deliveryStatusRepository;
    private  $repository;
    private  $manager;
    private  $userDodRepository;
    private  $userRepository;
    private  $dateDodRepository;

    use SelectionCommitteeMailTrait;

    public function __construct(SendingDeliveryStatusRepository $deliveryStatusRepository,
                                SendingRepository $repository, TransactionManager $manager,
                                UserRepository $userRepository,
                                UserDodRepository $userDodRepository,
                                DateDodRepository $dateDodRepository)
    {
        $this->repository = $repository;
        $this->deliveryStatusRepository = $deliveryStatusRepository;
        $this->manager = $manager;
        $this->userDodRepository = $userDodRepository;
        $this->dateDodRepository = $dateDodRepository;
        $this->userRepository = $userRepository;
    }

    public function createAndSend($dod_id, $typeSending) {
        $dateDod = $this->dateDodRepository->get($dod_id);
        if (SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_DOD,
            $typeSending, $dateDod->id)) {
            throw new \DomainException( 'Рассылка была  была завершена.');
        }
        if (($sendingTemplate = DictSendingTemplateHelper::dictTemplate(SendingDeliveryStatusHelper::TYPE_DOD,
                $typeSending)) == null) {
            throw new \DomainException( 'Нет шаблона рассылки. Обратитесь к админстратору.');
        }
        if (($typeSending == SendingDeliveryStatusHelper::TYPE_SEND_DOD_WEB) && !$dateDod->isDateActual()) {
            throw new \DomainException( 'Вы не можете рассылать, так как мероприятие уже прошло ');
        }
        if (!$dateDod->broadcast_link ) {
            throw new \DomainException( 'Вы не можете рассылать, так как отсутствует ссылка на данное мероприятие');
        }
        $userDodCount = clone $this->userDodAll($dateDod);
        if (!$userDodCount->count()) {
            throw new \DomainException( 'Нет ни одного юзера.');
        }

        $name = SendingDeliveryStatusHelper::deliveryTypeName($typeSending).". ".$dateDod->dodOne->name;
        $sending = Sending::createDefault($name, SendingDeliveryStatusHelper::TYPE_DOD,
            $dateDod->id, $typeSending, $sendingTemplate->id);
        $this->repository->save($sending);
        if ($typeSending == SendingDeliveryStatusHelper::TYPE_SEND_DOD_WEB) {
            $this->sendWeb($dateDod, $sending, $sendingTemplate, $typeSending);
        }

    }

    private function sendWeb(DateDod $dateDod,Sending $sending, $sendingTemplate, $typeSending) {
        foreach($this->userDodAll($dateDod)->all() as $userDod) {
            if(!$userDod->isFormLive() && $dateDod->isTypeIntramuralLiveBroadcast()) {
                continue;
            }
            $user = $this->userRepository->get($userDod->user_id);
            $this->send($user, $dateDod, $this->deliveryStatusRepository,
                SendingDeliveryStatusHelper::TYPE_DOD,
                $typeSending,
                $sending->id, $sendingTemplate);
        }
    }

    private function userDodAll(DateDod $dateDod)
    {
        return UserDod::find()->where(['dod_id' => $dateDod->id]);
    }



}