<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\repositories\DictCompetitiveGroupRepository;
use modules\entrant\models\UserCg;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementRepository;
use modules\entrant\repositories\UserCgRepository;

class ApplicationsService
{
    private $repository;
    public  $repositoryCg;
    private $statementCgRepository;
    private $statementRepository;
    private $transactionManager;

    public function __construct(UserCgRepository $repository,
                                DictCompetitiveGroupRepository $repositoryCg,
                                StatementCgRepository $statementCgRepository, StatementRepository $statementRepository, TransactionManager $transactionManager)
    {

        $this->repository = $repository;
        $this->repositoryCg = $repositoryCg;
        $this->statementCgRepository = $statementCgRepository;
        $this->transactionManager = $transactionManager;
        $this->statementRepository  = $statementRepository;
    }

    public function saveCg(DictCompetitiveGroup $cg){
        DictCompetitiveGroupHelper::oneProgramGovLineChecker($cg);
        DictCompetitiveGroupHelper::noMore3Specialty($cg);
        DictCompetitiveGroupHelper::isAvailableCg($cg);
        DictCompetitiveGroupHelper::budgetChecker($cg);
        $this->repository->haveARecord($cg->id);
        $userCg = UserCg::create($cg->id);
        $this->repository->save($userCg);
    }

    public function removeCg(DictCompetitiveGroup $cg) {
        $this->transactionManager->wrap(function() use ($cg) {
            $userCg = $this->repository->get($cg->id);
            $statementCg = $this->statementCgRepository->getUserStatement($userCg->cg_id, $userCg->user_id);
            if($statementCg) {
                if ($statementCg->statement->files) {
                    throw new \DomainException('Вы не можете удалить, так как у вас файл загружен');
                }
                $statement = $this->statementRepository->get($statementCg->statement_id);
                if($statement->getStatementCg()->count() == 1) {
                    $this->statementRepository->remove($statement);
                }else {
                    $this->statementCgRepository->remove($statementCg);
                }
            }
            $this->repository->remove($userCg);
        });
    }


}