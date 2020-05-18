<?php


namespace modules\entrant\services;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementConsentCgRepository;

class StatementConsentCgService
{
    private $repository;
    private $cgRepository;

    public function __construct(StatementConsentCgRepository $repository, StatementCgRepository $cgRepository)
    {
        $this->repository = $repository;
        $this->cgRepository = $cgRepository;
    }

    public function create($id, $userId)
    {
        $cg = $this->cgRepository->getUserStatementCg($id, $userId);
        if($this->repository->exits($userId, [StatementHelper::STATUS_DRAFT, StatementHelper::STATUS_WALT])) {
        throw new \DomainException('Вы уже сформировали заявление о зачислении');
        }
        if(!$cg->statement->countFilesAndCountPagesTrue()) {
            throw new \DomainException('Вы не можете сформировать заявление о согласии на зачисление, 
            так как не загружен скан заявления №'. $cg->statement->numberStatement.'!');
        }

        $stConsent = StatementConsentCg::create($cg->id, 0);
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
            throw new \DomainException('Вы не можете удалить заявление, так как загружен файл!');
        }
        $this->repository->remove($statement);
    }



}