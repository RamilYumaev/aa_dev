<?php


namespace common\auth\services;

use common\sending\helpers\DictSendingTemplateHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\repositories\SendingDeliveryStatusRepository;
use common\sending\traits\MailTrait;
use common\sending\traits\SelectionCommitteeMailTrait;
use dod\repositories\DateDodRepository;
use dod\repositories\UserDodRepository;
use olympic\repositories\OlimpicListRepository;

class DodConfirmService
{
    private $dateDodRepository;
    private $deliveryStatusRepository;
    private $userDodRepository;
    private $signupService;

    use SelectionCommitteeMailTrait;

    public function __construct(
        DateDodRepository $dateDodRepository,
        SendingDeliveryStatusRepository $deliveryStatusRepository,
        UserDodRepository $userDodRepository,
        SignupService $signupService
    )
    {
        $this->dateDodRepository= $dateDodRepository;
        $this->deliveryStatusRepository = $deliveryStatusRepository;
        $this->userDodRepository = $userDodRepository;
        $this->signupService = $signupService;
    }

    public function confirmDod($token, $dod_id) {
        if (($sendingTemplate = DictSendingTemplateHelper::dictTemplate(SendingDeliveryStatusHelper::TYPE_DOD,
                SendingDeliveryStatusHelper::TYPE_SEND_DOD_WEB_MESSAGE)) == null) {
            throw new \DomainException( 'Нет шаблона рассылки. Обратитесь к админстратору.');
        }
        $user = $this->signupService->confirm($token);

        $dod = $this->dateDodRepository->get($dod_id);
        $userDod = $this->userDodRepository->get($dod->id, $user->id);
        if (($dod->isTypeIntramuralLiveBroadcast() && $userDod->isFormLive() || $dod->haveDateTypes())) {
            $this->send($user, $dod, $this->deliveryStatusRepository,
                SendingDeliveryStatusHelper::TYPE_DOD,
                SendingDeliveryStatusHelper::TYPE_SEND_DOD_WEB_MESSAGE, null, $sendingTemplate);
        }
    }

}