<?php
namespace dod\services;

use dod\models\UserDod;
use dod\repositories\DateDodRepository;
use dod\repositories\UserDodRepository;
use olympic\repositories\auth\ProfileRepository;

class UserDodService
{
    private $dateDodRepository;
    private $repository;
    private $profileRepository;

    function __construct(UserDodRepository $repository, ProfileRepository $profileRepository, DateDodRepository $dateDodRepository)
    {
        $this->repository = $repository;
        $this->dateDodRepository = $dateDodRepository;
        $this->profileRepository= $profileRepository;
    }

    public function add($dod_id, $user_id) {
        $dod = $this->dateDodRepository->get($dod_id);
        $profile = $this->isAddProfile();
        $userDod = UserDod::create($dod->id, $user_id);
        $this->repository->save($userDod);
    }

    public function remove($dod_id, $user_id) {
        $userDod = $this->repository->get($dod_id, $user_id);
        $this->repository->remove($userDod);
    }

    private function isAddProfile () {
        $profile = $this->profileRepository->getUserId();
        if(is_null($profile)) {
            throw new \DomainException('Необходимо заполнить профиль');
        } else if ($profile->isNullProfile()) {
            throw new \DomainException('Необходимо заполнить профиль');
        }
        return $profile;
    }

}