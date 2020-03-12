<?php


namespace common\auth\services;

use common\sending\helpers\DictSendingTemplateHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\repositories\SendingDeliveryStatusRepository;
use common\sending\traits\MailTrait;
use olympic\repositories\OlimpicListRepository;

class OlympicConfirmService
{
    private $olimpicListRepository;
    private $deliveryStatusRepository;
    private $signupService;

    use MailTrait;

    public function __construct(
        OlimpicListRepository $olimpicListRepository,
        SendingDeliveryStatusRepository $deliveryStatusRepository,
        SignupService $signupService
    )
    {
        $this->olimpicListRepository = $olimpicListRepository;
        $this->deliveryStatusRepository = $deliveryStatusRepository;
        $this->signupService = $signupService;
    }

    public function confirmOlympic($token, $olympic) {
        if (($sendingTemplate = DictSendingTemplateHelper::dictTemplate(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_INVITATION)) == null) {
            throw new \DomainException( 'Нет шаблона рассылки. Обратитесь к админстратору.');
        }
        $user = $this->signupService->confirm($token);
        $olympic = $this->olimpicListRepository->get($olympic);
        if ($olympic->isFormOfPassageInternal()) {
            $this->send($user, $olympic, $this->deliveryStatusRepository,
                SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_INVITATION, null, $sendingTemplate);
        }
    }

}