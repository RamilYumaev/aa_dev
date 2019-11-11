<?php
namespace dod\services;


use dod\models\UserDod;
use dod\repositories\DateDodRepository;
use dod\repositories\UserDodRepository;

class UserDodService
{
    private $dateDodRepository;
    private $repository;

    function __construct(UserDodRepository $repository, DateDodRepository $dateDodRepository)
    {
        $this->repository = $repository;
        $this->dateDodRepository = $dateDodRepository;
    }

    public function add($dod_id, $user_id) {
        $dod = $this->dateDodRepository->get($dod_id);
        $userDod = UserDod::create($dod->id, $user_id);
        $this->repository->save($userDod);
    }

    public function remove($dod_id, $user_id) {
        $userDod = $this->repository->get($dod_id, $user_id);
        $this->repository->remove($userDod);
    }

}