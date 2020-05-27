<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementRepository;
use modules\entrant\repositories\UserCgRepository;

class StatementService
{
    private $repository;
    private $manager;
    private $cgRepository;
    /**
     * @var UserCgRepository
     */
    private $userCgRepository;

    public function __construct(StatementRepository $repository, UserCgRepository $userCgRepository,  StatementCgRepository $cgRepository, TransactionManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->cgRepository = $cgRepository;
        $this->userCgRepository = $userCgRepository;
    }

    public function create($facultyId, $specialityId, $specialRight, $eduLevel, $userId)
    {
        $this->manager->wrap(function () use ($facultyId, $specialityId, $specialRight, $eduLevel, $userId) {
                $model = Statement::find();
                $data = DictCompetitiveGroupHelper::idAllUser($userId, $facultyId, $specialityId);
                $max =  $model->lastMaxCounter($facultyId, $specialityId, $specialRight, $eduLevel, $userId);
                $modelOne = $model->statementUser($facultyId, $specialityId, $specialRight, $eduLevel, Statement::DRAFT, $userId);
                if(!$modelOne) {
                    if ($this->isStatementCg($data, $userId)) {
                        $statement = Statement::create($userId, $facultyId, $specialityId, $specialRight, $eduLevel, ++$max);
                        $this->repository->save($statement);
                        $this->statementCg($data, $userId, $statement->id);
                    }
                } else {
                    $this->statementCg($data, $userId, $modelOne->id);
                }
        });
    }

    public function addCountPages($id, $count){
        $statement = $this->repository->get($id);
        $statement->setCountPages($count);
        $this->repository->save($statement);
    }

    public function remove($id, $userId){
        $statementCg = $this->cgRepository->getUser($id, $userId);
        $this->manager->wrap(function () use($statementCg){
            $userCg =$this->userCgRepository->getUser($statementCg->cg_id, $statementCg->statement->user_id);
            $statement = $this->repository->get($statementCg->statement_id);
            if($statement->files) {
                throw new \DomainException('Вы не можете удалить заявление, так как загружен файл!');
            }
            if($statementCg->statementConsentFiles)  {
                throw new \DomainException('Вы не можете удалить образовательную программу, так как загружен файл в заявлении о зачислении!');
            }
            $this->userCgRepository->remove($userCg);
            if($statement->getStatementCg()->count() == 1) {
                $this->repository->remove($statement);
            } else {
                $this->cgRepository->remove($statementCg);
            }
        });
    }

    private function statementCg($data, $userId, $statementId){
        foreach ($data as $value) {
            if (!$this->isExits($value, $userId)){
                $cgUser = $this->userCgRepository->getUser($value, $userId);
                $statementCg = StatementCg::create($statementId, $value, null, $cgUser->cathedra_id);
                $this->cgRepository->save($statementCg);
            }
        }
    }

    private function isExits($cgId, $userId)
    {
        return Statement::find()->joinWith('statementCg')->where(['cg_id' => $cgId, 'user_id' => $userId ])->exists();
    }

    private function isStatementCg($data, $userId){
        foreach ($data as $value) {
            if (!$this->isExits($value, $userId)){
                 return true;
            }
        }
        return false;
    }






}