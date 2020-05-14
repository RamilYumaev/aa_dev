<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\IndividualAchievementsHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementIa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\repositories\IndividualAchievementsRepository;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementIaRepository;
use modules\entrant\repositories\StatementIndividualAchievementsRepository;
use modules\entrant\repositories\StatementRepository;
use modules\entrant\repositories\UserCgRepository;

class StatementIndividualAchievementsService
{
    private $repository;
    private $manager;
    private $repositoryUserIa;
    private $statementIaRepository;

    public function __construct(StatementIndividualAchievementsRepository $repository,
                                IndividualAchievementsRepository $repositoryUserIa, StatementIaRepository $statementIaRepository, TransactionManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->repositoryUserIa = $repositoryUserIa;
        $this->statementIaRepository = $statementIaRepository;
    }

    public function create($userId)
    {
        $this->manager->wrap(function () use ($userId) {
            $data = DictCompetitiveGroupHelper::getEduLevelsArrayIA();
            $model = StatementIndividualAchievements::find();
            foreach ($data as $eduLevel) {
                if(IndividualAchievementsHelper::isExits($userId, $eduLevel)){
                    $max =  $model->lastMaxCounter($eduLevel, $userId);
                    $dataIndividual = IndividualAchievementsHelper::column($userId, $eduLevel);
                    $modelOne = $model->statementIAUser($eduLevel, StatementIndividualAchievements::DRAFT, $userId);
                    if(!$modelOne) {
                        if ($this->isStatementIa($data, $userId)) {
                            $statementIa = StatementIndividualAchievements::create($userId, $eduLevel, ++$max);
                            $this->repository->save($statementIa);
                            $this->statementIa($dataIndividual, $userId, $statementIa->id);
                        }else {
                            $this->statementIa($dataIndividual, $userId, $modelOne->id);
                        }
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

    private function statementIa($data, $userId, $statementId){
        foreach ($data as $value) {
            if (!$this->isExits($value, $userId)){
                $statementIa = StatementIa::create($statementId, $value, null);
                $this->statementIaRepository->save($statementIa);
            }
        }
    }

    private function isExits($individualId, $userId)
    {
        return StatementIndividualAchievements::find()->joinWith('statementIa')->where(['individual_id' => $individualId, 'user_id' => $userId])->exists();
    }

    private function isStatementIa($data, $userId){
        foreach ($data as $value) {
            if (!$this->isExits($value, $userId)){
                return true;
            }
        }
        return false;
    }


}