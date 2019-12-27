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

    public function createAndSend($olympic_id) {
        $olympic= $this->olimpicListRepository->get($olympic_id);
        if (SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
            SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA, $olympic->id)) {
            throw new \DomainException( 'Рассылка была создана.');
        }
        if (($sendingTemplate = DictSendingTemplateHelper::dictTemplate(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA)) == null) {
            throw new \DomainException( 'Нет шаблона рассылки. Обратитесь к админстратору.');
        }
        $this->manager->wrap(function () use($olympic, $sendingTemplate){
            $name = SendingDeliveryStatusHelper::deliveryTypeName(SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA).". ".$olympic->name;
            $sending = Sending::createDefault($name, SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                $olympic->id, SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA, $sendingTemplate->id);
            $this->repository->save($sending);
            $diplomaAll  = Diploma::find()->olympic($olympic->id)->all();
            foreach($diplomaAll as $diploma) {
                $user = $this->userRepository->get($diploma->user_id);
                $this->send($user, $olympic, $this->deliveryStatusRepository,
                    SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                    SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA,
                    $sending->id, $sendingTemplate);
            }
            $sendingUpdate = $this->repository->get($sending->id);
            $sendingUpdate->status_id = SendingHelper::FINISH_SENDING;
            $this->repository->save($sendingUpdate);
        });
    }


}