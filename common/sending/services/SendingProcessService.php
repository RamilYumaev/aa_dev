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
use common\transactions\TransactionManager;
use olympic\models\Diploma;
use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;
use olympic\models\UserOlimpiads;
use olympic\repositories\OlimpicListRepository;

class SendingProcessService
{
    private  $deliveryStatusRepository;
    private  $repository;
    private  $manager;
    private  $olimpicListRepository;
    private  $userRepository;

    use MailTrait;

    public function __construct(SendingDeliveryStatusRepository $deliveryStatusRepository,
                                SendingRepository $repository, TransactionManager $manager,
                                UserRepository $userRepository,
                                OlimpicListRepository $olimpicListRepository)
    {
        $this->repository = $repository;
        $this->deliveryStatusRepository = $deliveryStatusRepository;
        $this->manager = $manager;
        $this->olimpicListRepository = $olimpicListRepository;
        $this->userRepository = $userRepository;
    }

    public function createAndSend($olympic_id, $typeSending) {
        $olympic= $this->olimpicListRepository->get($olympic_id);
        if (SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
            $typeSending, $olympic->id)) {
            throw new \DomainException( 'Рассылка была создана.');
        }
        if (($sendingTemplate = DictSendingTemplateHelper::dictTemplate(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                $typeSending)) == null) {
            throw new \DomainException( 'Нет шаблона рассылки. Обратитесь к админстратору.');
        }
        if (($typeSending == SendingDeliveryStatusHelper::TYPE_SEND_INVITATION_AFTER_DISTANCE_TOUR) &&
            $olympic->getTimeStartTourMatchDate()) {
            throw new \DomainException( 'Вы не можете рассылать пригласительные на очный тур, 
            так как он уже прошел '. $olympic->date_time_start_tour);
        }
            $name = SendingDeliveryStatusHelper::deliveryTypeName($typeSending).". ".$olympic->name;
            $sending = Sending::createDefault($name, SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                $olympic->id, $typeSending, $sendingTemplate->id);
            $this->repository->save($sending);
            if ($typeSending == SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA) {
                $this->sendDiploma($olympic, $sending, $sendingTemplate, $typeSending);
            }
            elseif ($typeSending == SendingDeliveryStatusHelper::TYPE_SEND_PRELIMINARY) {
                $this->sendPreliminaryResult($olympic, $sending, $sendingTemplate, $typeSending);
            }
            elseif ($typeSending == SendingDeliveryStatusHelper::TYPE_SEND_INVITATION) {
                $this->sendInvitationFirst($olympic, $sending, $sendingTemplate, $typeSending);
            }
            else {
                $this->sendInvitation($olympic, $sending, $sendingTemplate, $typeSending);
            }
            $sendingUpdate = $this->repository->get($sending->id);
            $sendingUpdate->status_id = SendingHelper::FINISH_SENDING;
            $this->repository->save($sendingUpdate);
    }

    private function sendDiploma(OlimpicList $olympic,Sending $sending, $sendingTemplate, $typeSending) {
        $diplomaAll  = Diploma::find()->olympic($olympic->id)->all();
        if(!count($diplomaAll)) {
            throw new \DomainException( 'У участников не сформированы дипломы');
        }
        foreach($diplomaAll as $diploma) {
            $user = $this->userRepository->get($diploma->user_id);
            $this->send($user, $olympic, $this->deliveryStatusRepository,
                SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                $typeSending,
                $sending->id, $sendingTemplate);
        }
    }

    private function sendInvitation(OlimpicList $olympic,Sending $sending, $sendingTemplate, $typeSending) {
        $ppt  = PersonalPresenceAttempt::find()->olympic($olympic->id)->all();
        foreach($ppt as $invitation) {
            $user = $this->userRepository->get($invitation->user_id);
            $this->send($user, $olympic, $this->deliveryStatusRepository,
                SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                $typeSending,
                $sending->id, $sendingTemplate);
        }
    }

    private function sendInvitationFirst(OlimpicList $olympic,Sending $sending, $sendingTemplate, $typeSending) {
        $userOlympic  = UserOlimpiads::find()->where(['olympiads_id' => $olympic->id])->all();
        foreach($userOlympic  as $invitation) {
            $user = $this->userRepository->get($invitation->user_id);
            $this->send($user, $olympic, $this->deliveryStatusRepository,
                SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                $typeSending,
                $sending->id, $sendingTemplate);
        }
    }

    private function sendPreliminaryResult(OlimpicList $olympic,Sending $sending, $sendingTemplate, $typeSending) {
        $ppt  = PersonalPresenceAttempt::find()->olympic($olympic->id)->presence()->all();
        foreach($ppt as $pr) {
            $user = $this->userRepository->get($pr->user_id);
            $this->send($user, $olympic, $this->deliveryStatusRepository,
                SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                $typeSending,
                $sending->id, $sendingTemplate);
        }
    }

}