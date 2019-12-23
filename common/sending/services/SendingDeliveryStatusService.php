<?php


namespace common\sending\services;


use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\repositories\SendingDeliveryStatusRepository;

class SendingDeliveryStatusService
{

    private  $repository;

    public function __construct(SendingDeliveryStatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function statusRead($id){
       $deliveryStatus = $this->repository->get($id);
       $deliveryStatus->setStatus(SendingDeliveryStatusHelper::STATUS_READ);
       $this->repository->save($deliveryStatus);
    }

}