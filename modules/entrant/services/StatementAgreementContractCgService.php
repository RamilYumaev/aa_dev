<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\entrant\behaviors\ContractBehavior;
use modules\entrant\forms\ContractMessageForm;
use modules\entrant\forms\FilePdfForm;
use modules\entrant\forms\LegalEntityForm;
use modules\entrant\forms\PersonalEntityForm;
use modules\entrant\forms\ReceiptContractForm;
use modules\entrant\forms\ReceiptContractMessageForm;
use modules\entrant\helpers\ContractHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\ReceiptHelper;
use modules\entrant\models\File;
use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
use modules\entrant\models\ReceiptContract;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\repositories\LegalEntityRepository;
use modules\entrant\repositories\PersonalEntityRepository;
use modules\entrant\repositories\ReceiptContractRepository;
use modules\entrant\repositories\StatementAgreementContractCgRepository;
use modules\entrant\repositories\StatementCgRepository;

class StatementAgreementContractCgService
{
    private $repository;
    private $cgRepository;
    private $personalEntityRepository;
    private $legalEntityRepository;
    private $transactionManager;
    private $receiptContractRepository;
    private $userAisService;

    public function __construct( StatementAgreementContractCgRepository  $repository,
                                 StatementCgRepository $cgRepository,
                                 PersonalEntityRepository $personalEntityRepository,
                                 LegalEntityRepository $legalEntityRepository,
                                 UserAisService $userAisService,
                                 ReceiptContractRepository $receiptContractRepository,
                                 TransactionManager $transactionManager
    )
    {
        $this->repository = $repository;
        $this->cgRepository = $cgRepository;
        $this->personalEntityRepository = $personalEntityRepository;
        $this->legalEntityRepository = $legalEntityRepository;
        $this->transactionManager = $transactionManager;
        $this->receiptContractRepository = $receiptContractRepository;
        $this->userAisService = $userAisService;
    }

    public function create($id, $userId)
    {
        $cg = $this->cgRepository->getUserStatementCg($id, $userId);
        if($this->repository->exits($userId, $cg->id)) {
        throw new \DomainException('Вы уже сформировали договор об оказании платных образовательных услуг');
        }

        $stConsent = StatementAgreementContractCg::create($cg->id);
        $this->repository->save($stConsent);
    }

    public function addCountPages($id, $count){
        $statement = $this->repository->get($id);
        $statement->setCountPages($count);
        $statement->detachBehavior('contract');
        $this->repository->save($statement);
    }

    public function addCountPagesReceipt($id, $count){
        $receipt = $this->receiptContractRepository->getId($id);
        $receipt->setCountPages($count);
        $this->receiptContractRepository->save($receipt);
    }

    public function deleteReceipt($id){
        $receipt = $this->receiptContractRepository->getId($id);
        $this->receiptContractRepository->remove($receipt);
    }

    public function dataReceipt($id, ReceiptContractForm $form){
        $receipt = $this->receiptContractRepository->getId($id);
        $receipt->data($form);
        $this->receiptContractRepository->save($receipt);
    }

    public function addNumber($id, $number){
        $statement = $this->repository->get($id);
        $statement->setNumber($number);
        $statement->detachBehavior('contract');
        $this->repository->save($statement);
    }

    public function remove($id, $userId){
        $statement = $this->repository->getFull($id, $userId);
        if($statement->files) {
            throw new \DomainException('Вы не можете удалить  , так как загружен файл!');
        }
        $this->repository->remove($statement);
    }

    public function add($id,  $customer, $rec = 0)
    {
        $statement = $this->repository->get($id);
        $statement->setType($customer);
        if($rec) {
            if($statement->type == 2) {
               if(!$this->personalEntityRepository->getIdUser($rec, $statement->statementCg->statement->user_id)) {
                   throw new \DomainException('Данные не найдены');
               }
            }
            if($statement->type == 3) {
                if(!$this->legalEntityRepository->getIdUser($rec, $statement->statementCg->statement->user_id)) {
                    throw new \DomainException('Данные не найдены '.$rec);
                }
            }
        }
        $statement->setRecordId($rec);
        $statement->detachBehavior('contract');
        $this->repository->save($statement);
        return $statement;
    }

    public function createOrUpdatePersonal(PersonalEntityForm $form, $id)
    {
        $statement = $this->repository->get($id);
        if(($model = $this->personalEntityRepository->getIdUser($statement->record_id, $form->user_id)) !== null) {
            $model->data($form);
        }else {
            $model= PersonalEntity::create($form);
        }
         $this->transactionManager->wrap(function () use($statement, $model) {
             $this->personalEntityRepository->save($model);
             $statement->setRecordId($model->id);
             $statement->detachBehavior('contract');
             $this->repository->save($statement);
         });

    }

    public function createOrUpdateLegal(LegalEntityForm $form, $id)
    {
        $statement = $this->repository->get($id);
        if(($model = $this->legalEntityRepository->getIdUser($statement->record_id, $form->user_id)) !== null) {
            $model->data($form);
        }else {
            $model= LegalEntity::create($form);
        }
        $this->transactionManager->wrap(function () use($statement, $model) {
            $this->personalEntityRepository->save($model);
            $statement->detachBehavior('contract');
            $statement->setRecordId($model->id);

            $this->repository->save($statement);
        });
    }

    public function addReceipt($period, $id)
    {
        $contract = $this->repository->get($id);

        if($this->receiptContractRepository->isExitsContract($contract->id)) {
            throw new \DomainException('Вы уже сформировали квитанцию');
        }

        $cost =  $contract->statementCg->cg->education_year_cost;
        $discount = $contract->statementCg->cg->discount;
        $totalCost = $cost - ($cost * ($discount/100));
        $receiptCost = ReceiptHelper::costDefault($totalCost, ReceiptHelper::listSep()[$period]);
        $a = str_replace(',','.',$receiptCost);
        $a = preg_replace( "/[^x\d|*\.]/", "", $a);

        $receipt = ReceiptContract::create($contract->id, $period, $a);
        $this->receiptContractRepository->save($receipt);
    }

    public function statusReceipt(ReceiptContract $receiptContract, $status)
    {
        $receiptContract->setStatus($status);
        if($status != ContractHelper::STATUS_VIEW) {
            $this->filesReceipt($receiptContract, $status);
        }
        $this->receiptContractRepository->save($receiptContract);
    }

    public function status($id, $status, $emailId)
    {
        $statement = $this->repository->get($id);
        $statement->setStatus($status);
        if($status == ContractHelper::STATUS_ACCEPTED) {
            $statement->setMessage(null);
        }
        if($status == ContractHelper::STATUS_WALT || $status == ContractHelper::STATUS_ACCEPTED) {
            $this->filesContract($statement, $status);
        }
        $this->repository->save($statement);
        if($statement->statusAccepted()) {
            $this->userAisService->contractSend($emailId,
            $statement->statementCg->statement->user_id, $statement->textEmail);
        }
    }

    public function month($id, $status)
    {
        $statement = $this->repository->get($id);
        $statement->setIsMonth($status);
        $this->repository->save($statement);
    }


    public function addFile($id, FilePdfForm $form)
    {
        $statement = $this->repository->get($id);
        if($form->file_name) {
            $statement->setFile($form->file_name);
        }
        $this->repository->save($statement);
    }

    public function addMessage($id, ContractMessageForm $form)
    {
        $statement = $this->repository->get($id);
        $statement->setMessage($form->message);
        $statement->setStatus(ContractHelper::STATUS_NO_ACCEPTED);
        $this->filesContract($statement, FileHelper::STATUS_NO_ACCEPTED);
        $this->repository->save($statement);
    }

    public function addMessageReceipt(ReceiptContract $receiptContract, ReceiptContractMessageForm $form)
    {
        $receiptContract->setMessage($form->message);
        $receiptContract->setStatus(ContractHelper::STATUS_NO_ACCEPTED);
        $this->filesReceipt($receiptContract, FileHelper::STATUS_NO_ACCEPTED);
        $this->receiptContractRepository->save($receiptContract);
    }

    public function filesContract(StatementAgreementContractCg $agreementContractCg, $status)
    {
        foreach ($agreementContractCg->files as $file) {
            /* @var $file File */
            $file->setStatus($status);
            $file->save();
        }

    }

    public function filesReceipt(ReceiptContract $receiptContract, $status)
    {
        foreach ($receiptContract->files as $file) {
            /* @var $file File */
            $file->setStatus($status);
            $file->save();
        }
    }
}