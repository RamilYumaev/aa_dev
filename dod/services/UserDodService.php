<?php
namespace dod\services;

use dictionary\repositories\DictSchoolsRepository;
use dod\forms\SignUpDodRemoteUserForm;
use dod\models\UserDod;
use dod\repositories\DateDodRepository;
use dod\repositories\UserDodRepository;
use olympic\repositories\auth\ProfileRepository;
use olympic\traits\NewOrRenameSchoolTrait;

class UserDodService
{
    use NewOrRenameSchoolTrait;
    private $dateDodRepository;
    private $repository;
    private $profileRepository;
    private $dictSchoolsRepository;

    function __construct(UserDodRepository $repository, ProfileRepository $profileRepository, DateDodRepository $dateDodRepository,
                         DictSchoolsRepository $dictSchoolsRepository)
    {
        $this->repository = $repository;
        $this->dateDodRepository = $dateDodRepository;
        $this->profileRepository= $profileRepository;
        $this->dictSchoolsRepository = $dictSchoolsRepository;
    }

    public function add($dod_id, $user_id, $type = null) {
        $dod = $this->dateDodRepository->get($dod_id);
        $profile = $this->isAddProfile();
        if($dod->isTypeIntramuralLiveBroadcast()) {
            $userDod = UserDod::create($dod->id, $user_id, $type);
        }else {
            $userDod = UserDod::create($dod->id, $user_id);
        }
        $this->repository->save($userDod);
    }

    public function addRemoteEdu(SignUpDodRemoteUserForm $form, $user_id) {
        $dod = $this->dateDodRepository->get($form->dateDodId);
        $userDod = UserDod::create($dod->id, $user_id, null, $form->statusDodUser->status_edu,
            $this->newOrRenameSchoolId($form->schoolUser, $this->dictSchoolsRepository), $form->statusDodUser->count);
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