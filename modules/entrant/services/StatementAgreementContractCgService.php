<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use modules\entrant\forms\LegalEntityForm;
use modules\entrant\forms\PersonalEntityForm;
use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\repositories\LegalEntityRepository;
use modules\entrant\repositories\PersonalEntityRepository;
use modules\entrant\repositories\StatementAgreementContractCgRepository;
use modules\entrant\repositories\StatementCgRepository;

class StatementAgreementContractCgService
{
    private $repository;
    private $cgRepository;
    private $personalEntityRepository;
    private $legalEntityRepository;
    private $transactionManager;

    public function __construct( StatementAgreementContractCgRepository  $repository,
                                 StatementCgRepository $cgRepository,
                                 PersonalEntityRepository $personalEntityRepository,
                                 LegalEntityRepository $legalEntityRepository,
                                 TransactionManager $transactionManager
)
    {
        $this->repository = $repository;
        $this->cgRepository = $cgRepository;
        $this->personalEntityRepository = $personalEntityRepository;
        $this->legalEntityRepository = $legalEntityRepository;
        $this->transactionManager = $transactionManager;
    }

    public function create($id, $userId)
    {
        $cg = $this->cgRepository->getUserStatementCg($id, $userId);
        if($this->repository->exits($userId)) {
        throw new \DomainException('Вы уже сформировали договор об оказании платных образовательных услуг');
        }

        $stConsent = StatementAgreementContractCg::create($cg->id);
        $this->repository->save($stConsent);
    }

    public function addCountPages($id, $count){
        $statement = $this->repository->get($id);
        $statement->setCountPages($count);
        $this->repository->save($statement);
    }

    public function remove($id, $userId){
        $statement = $this->repository->getFull($id, $userId);
        if($statement->files) {
            throw new \DomainException('Вы не можете удалить  , так как загружен файл!');
        }
        $this->repository->remove($statement);
    }

    public function add($id,  $customer)
    {
        $statement = $this->repository->get($id);
        $statement->setType($customer);
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
            $statement->setRecordId($model->id);
            $this->repository->save($statement);
        });

    }



}