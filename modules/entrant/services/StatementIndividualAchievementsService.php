<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\forms\StatementIAMessageForm;
use modules\entrant\forms\StatementIndividualAchievementsMessageForm;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\IndividualAchievementsHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementIa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\repositories\FileRepository;
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
    private $fileRepository;

    public function __construct(StatementIndividualAchievementsRepository $repository,
                                IndividualAchievementsRepository $repositoryUserIa,
                                StatementIaRepository $statementIaRepository,
                                FileRepository $fileRepository, TransactionManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->repositoryUserIa = $repositoryUserIa;
        $this->statementIaRepository = $statementIaRepository;
        $this->fileRepository = $fileRepository;
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
                        if ($this->isStatementIa($dataIndividual, $userId)) {
                            $statementIa = StatementIndividualAchievements::create($userId, $eduLevel, ++$max);
                            $this->repository->save($statementIa);
                            $this->statementIa($dataIndividual, $userId, $statementIa->id);
                        }
                    }
                    else {
                        $this->statementIa($dataIndividual, $userId, $modelOne->id);
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

    public function addStatusStatement($id, $status)
    {
        $statement = $this->repository->get($id);
        $statement->setStatus($status);
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

    public function addStatus($id, $status){
        $st = $this->statementIaRepository->get($id);
        $st->setStatus($status);
        if($status == StatementHelper::STATUS_ACCEPTED) {
            $st->setMessage(null);
        }
        $this->statementIaRepository->save($st);
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

    public function addStatusIndex($id, $status)
    {   $model = $this->repository->get($id);
        $this->manager->wrap(function () use ($model, $status) {
            $model->setStatus($status);
            foreach($model->statementIa as $st) {
                $st->setStatus($status);
                foreach ($st->userIndividualAchievements->dictOtherDocument->files as $docFile)   {
                    $docFile->setStatus(FileHelper::STATUS_WALT);
                    $this->fileRepository->save($docFile);
                }
                $this->statementIaRepository->save($st);
            }
            foreach($model->files as $file) {
                $file->setStatus(FileHelper::STATUS_WALT);
                $this->fileRepository->save($file);
            }
            $model->setMessage(null);
            $this->repository->save($model);
        });
    }

    public function addMessage($id, StatementIndividualAchievementsMessageForm $form)
    {   $model = $this->repository->get($id);
        $this->manager->wrap(function () use ($model, $form) {
        $model->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
        foreach($model->statementIa as $st) {
            $st->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
            foreach ($st->userIndividualAchievements->dictOtherDocument->files as $docFile)   {
                $docFile->setStatus(FileHelper::STATUS_NO_ACCEPTED);
                $this->fileRepository->save($docFile);
            }
            $this->statementIaRepository->save($st);
        }
        foreach($model->files as $file) {
            $file->setStatus(FileHelper::STATUS_NO_ACCEPTED);
            $this->fileRepository->save($file);
        }
        $model->setMessage($form->message);
        $this->repository->save($model);
        });
    }

    public function addMessageIa($id, StatementIAMessageForm $form)
    {
        $st = $this->statementIaRepository->get($id);
        $st->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
        $st->setMessage($form->message);
        $this->statementIaRepository->save($st);
    }



}