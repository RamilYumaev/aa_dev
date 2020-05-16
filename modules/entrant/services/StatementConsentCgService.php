<?php


namespace modules\entrant\services;


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
        $stConsent = StatementConsentCg::create($cg->id, 0);
        $this->repository->save($stConsent);
    }

    public function addCountPages($id, $count){
        $statement = $this->repository->get($id);
        $statement->setCountPages($count);
        $this->repository->save($statement);
    }


}