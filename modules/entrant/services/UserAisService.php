<?php


namespace modules\entrant\services;

use common\auth\repositories\UserRepository;
use modules\entrant\models\UserAis;
use modules\usecase\RepositoryDeleteSaveClass;

class UserAisService
{
    private $repository;
    private $userRepository;

    public function __construct(RepositoryDeleteSaveClass $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function create($userId, $incomingId)
    {
        $model  = UserAis::create($userId, $incomingId);
        $this->repository->save($model);
    }
}