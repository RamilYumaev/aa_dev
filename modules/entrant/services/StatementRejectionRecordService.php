<?php


namespace modules\entrant\services;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\AisOrderTransfer;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\models\StatementRejectionRecord;
use modules\entrant\repositories\AisTransferOrderRepository;
use modules\entrant\repositories\StatementRejectionRecordRepository;

class StatementRejectionRecordService
{
    private $repository;
    private $aisTransferOrderRepository;

    public function __construct(StatementRejectionRecordRepository $repository, AisTransferOrderRepository $aisTransferOrderRepository)
    {
        $this->repository = $repository;
        $this->aisTransferOrderRepository = $aisTransferOrderRepository;
    }

    public function create($id, $userId)
    {
        $order = $this->aisTransferOrderRepository->get($id);
        $this->repository->isStatementRejection($userId, $order->cg->id);
        $st = StatementRejectionRecord::create($order->cg->id, 0, $userId, $order->order_date, $order->order_name);
        $this->repository->save($st);
    }

    public function addCountPages($id, $count){
        $statement = $this->repository->get($id);
        $statement->setCountPages($count);
        $this->repository->save($statement);
    }

    public function remove($id){
        $statement = $this->repository->get($id);
        $this->repository->remove($statement);
    }

    public function status($id, $status)
    {
        $statement = $this->repository->get($id);
        $statement->setStatus($status);
        $this->repository->save($statement);
    }

    public function addFile($id, \modules\entrant\forms\FilePdfForm $form)
    {
        $statement = $this->repository->get($id);
        if($form->file_name) {
            $statement->setFile($form->file_name);
        }
        $this->repository->save($statement);
    }

}