<?php


namespace modules\entrant\services;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementConsentCgRepository;
use modules\entrant\repositories\StatementRejectionCgConsentRepository;

class StatementConsentCgService
{
    private $repository;
    private $cgRepository;
    private $rejectionCgConsentRepository;

    public function __construct(StatementConsentCgRepository $repository, StatementCgRepository $cgRepository,
                                StatementRejectionCgConsentRepository $rejectionCgConsentRepository)
    {
        $this->repository = $repository;
        $this->cgRepository = $cgRepository;
        $this->rejectionCgConsentRepository =$rejectionCgConsentRepository;
    }

    public function create($id, $userId)
    {
        $cg = $this->cgRepository->getUserStatementCg($id, $userId);
        if($this->repository->exits($userId, [StatementHelper::STATUS_DRAFT,
            StatementHelper::STATUS_WALT,
            StatementHelper::STATUS_ACCEPTED])) {
        throw new \DomainException('Вы уже сформировали заявление о зачислении');
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

    public function rejection($id) {
        $statement = $this->repository->get($id);
        if (!$statement) {
            throw new \DomainException('Заявление о зачислении не найдено.');
        }
        $this->rejectionCgConsentRepository->isStatementConsentRejection($statement->id);
        $this->rejectionCgConsentRepository->save(StatementRejectionCgConsent::create($statement->id));
    }


}