<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\IndividualAchievementsHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\repositories\IndividualAchievementsRepository;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementIARepository;
use modules\entrant\repositories\StatementRepository;
use modules\entrant\repositories\UserCgRepository;

class StatementIAService
{
    private $repository;
    private $manager;
    private $cgRepository;
    private $repositoryUserIa;

    public function __construct(StatementIARepository $repository, IndividualAchievementsRepository $repositoryUserIa, TransactionManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->repositoryUserIa = $repositoryUserIa;
    }

    public function create($userId)
    {
        $this->manager->wrap(function () use ($userId) {
                $data = DictCompetitiveGroupHelper::getEduLevelsArrayIA();
                foreach ($data as $eduLevel) {
                     if(IndividualAchievementsHelper::isExits($userId, $eduLevel)){
                         if(!$this->repository->getStatementIAFull($userId, $eduLevel)) {
                             $statementIa = StatementIndividualAchievements::create($userId, $eduLevel, 1);
                             $this->repository->save($statementIa);
                         }
                    }
                }
        });
    }

    public function addCountPages($id, $count)
    {
        $statement = $this->repository->get($id);
        $statement->setCountPages($count);
        $this->repository->save($statement);
    }


}