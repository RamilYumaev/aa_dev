<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementRepository;

class StatementService
{
    private $repository;
    private $manager;
    private $cgRepository;

    public function __construct(StatementRepository $repository,  StatementCgRepository $cgRepository, TransactionManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->cgRepository = $cgRepository;
    }

    public function create($facultyId, $specialityId, $specialRight, $eduLevel, $userId)
    {
        $this->manager->wrap(function () use ($facultyId, $specialityId, $specialRight, $eduLevel, $userId) {
                $model = Statement::find();
                $max =  $model->lastMaxCounter($facultyId, $specialityId, $specialRight, $eduLevel);
                $modelOne = $model->statementUser($facultyId, $specialityId, $specialRight, $eduLevel, Statement::DRAFT, $userId);
                if(!$modelOne) {
                    $statement = Statement::create($userId, $facultyId, $specialityId, $specialRight, $eduLevel, ++$max);
                    $this->repository->save($statement);
                    $this->statementCg($userId, $facultyId, $specialityId, $statement->id);
                } else {
                    $this->statementCg($userId, $facultyId, $specialityId, $modelOne->id);
                }
        });
    }

    private function statementCg($userId, $facultyId, $specialityId, $statementId){
        foreach (DictCompetitiveGroupHelper::idAllUser($userId, $facultyId, $specialityId) as $value) {
            $statementExits = Statement::find()->joinWith('statementCg')->where(['cg_id' => $value])->exists();
            if (!$statementExits){
                $statementCg = StatementCg::create($statementId, $value, null);
                $this->cgRepository->save($statementCg);
            }
        }
    }

}