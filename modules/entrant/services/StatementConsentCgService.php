<?php


namespace modules\entrant\services;


use modules\dictionary\models\SettingEntrant;
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

        if(!SettingEntrant::find()->existsFormEduOpen($cg->cg, SettingEntrant::ZOS)) {
            throw new \DomainException('Прием заявлений о согласии на зачисление завершен');
        }

        if(($this->repository->exits($userId, [StatementHelper::STATUS_DRAFT,
            StatementHelper::STATUS_WALT,
            StatementHelper::STATUS_ACCEPTED, StatementHelper::STATUS_VIEW]) && $cg->cg->isBudget()) ||
            ($this->repository->exitsCg($userId, [StatementHelper::STATUS_DRAFT,
                StatementHelper::STATUS_WALT,
                StatementHelper::STATUS_ACCEPTED, StatementHelper::STATUS_VIEW], $cg->cg_id) && $cg->cg->isContractCg())
        ) {
        throw new \DomainException('Вы уже сформировали заявление о согласии на зачисление');
        }


        if($cg->statement->statusRecallNoAccepted()) {
            throw new \DomainException('Вы не можете сформироавть заявление о согласии , так как у вас имеется 
            отозванное или непринятое заявление об участии в конкурсе');
        }

        if($cg->countBudgetConsent()) {
            throw new \DomainException('Вы не можете сформироавть заявление о согласии на зачисление, так как достигнут лимит (не более 2-х раз в Университет) ');
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



    public function rejectionRemove($id) {
        $statement = $this->rejectionCgConsentRepository->get($id);
        $this->rejectionCgConsentRepository->remove($statement);
    }

    public function statusView($id)
    {
        $statement = $this->repository->get($id);
        $statement->setStatus(StatementHelper::STATUS_VIEW);
        $this->repository->save($statement);
    }

    public function statusDraft($id)
    {
        $statement = $this->repository->get($id);
        $statement->setStatus(StatementHelper::STATUS_WALT);
        $this->repository->save($statement);
    }

    public function statusNo($id)
    {
        $statement = $this->repository->get($id);
        $statement->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
        $this->repository->save($statement);
    }


}