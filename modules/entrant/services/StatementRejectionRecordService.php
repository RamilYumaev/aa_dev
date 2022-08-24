<?php


namespace modules\entrant\services;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\AisOrderTransfer;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\models\StatementRejectionRecord;
use modules\entrant\repositories\AisTransferOrderRepository;
use modules\entrant\repositories\StatementConsentCgRepository;
use modules\entrant\repositories\StatementRejectionRecordRepository;

class StatementRejectionRecordService
{
    private $repository;
    private $aisTransferOrderRepository;
    private $consentCgRepository;

    public function __construct(StatementRejectionRecordRepository $repository,
                                AisTransferOrderRepository $aisTransferOrderRepository, StatementConsentCgRepository $consentCgRepository)
    {
        $this->repository = $repository;
        $this->aisTransferOrderRepository = $aisTransferOrderRepository;
        $this->consentCgRepository = $consentCgRepository;
    }

    public function create($id, $userId)
    {
        $order = $this->aisTransferOrderRepository->get($id);
        $this->repository->isStatementRejection($userId, $order->cg->id);
//        if(!$order->cg->isHighGraduate() && !$order->cg->isZaOchCg()) {
//            throw new \DomainException('Прием заявлений об исключении из приказа о зачислении завершен');
//        }
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
        if($statement->isStatusAccepted()) {
           $consent = $this->consentCgRepository->oneAcceptedCg($statement->user_id, $statement->cg_id);
           if($consent) {
               $consent->setStatus(StatementHelper::STATUS_RECALL);
               $this->consentCgRepository->save($consent);
           }
        }
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