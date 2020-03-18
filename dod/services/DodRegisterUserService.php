<?php
namespace dod\services;

use common\auth\forms\SignupForm;
use common\auth\repositories\UserRepository;
use common\sending\traits\SelectionCommitteeMailTrait;
use common\transactions\TransactionManager;
use dictionary\repositories\DictSchoolsRepository;
use dod\forms\SignupDodForm;
use dod\models\DateDod;
use dod\models\UserDod;
use dod\repositories\DateDodRepository;
use dod\repositories\UserDodRepository;
use olympic\forms\auth\ProfileCreateForm;
use olympic\repositories\auth\ProfileRepository;
use olympic\models\auth\Profiles;
use common\auth\models\User;
use olympic\traits\NewOrRenameSchoolTrait;


class DodRegisterUserService
{

    private $transaction;

    private $userRepository;
    private $profileRepository;
    private $dodRepository;
    private $userDodRepository;
    private $dictSchoolsRepository;

    use SelectionCommitteeMailTrait;
    use NewOrRenameSchoolTrait;

    public function __construct(
        UserDodRepository $userDodRepository,
        DateDodRepository $dodRepository,
        UserRepository $userRepository,
        ProfileRepository $profileRepository,
        TransactionManager $transaction,
        DictSchoolsRepository $dictSchoolsRepository
    )
    {
        $this->userDodRepository = $userDodRepository;
        $this->dodRepository = $dodRepository;
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
        $this->transaction = $transaction;
        $this->dictSchoolsRepository = $dictSchoolsRepository;
    }

    public function signup(SignupDodForm $form): void
    {
        $this->transaction->wrap(function () use ($form) {

            $user = $this->newUser($form->user);
            $this->userRepository->save($user);

            $profile = $this->newProfile($form->profile, $user->id);
            $this->profileRepository->save($profile);

            $dateDod = $this->dodRepository->get($form->dateDodId);
            $userDod = $this->newUserDod($dateDod, $user->id, $form);
            $this->userDodRepository->save($userDod);

            $configTemplate =  ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'];
            $configData = ['user' => $user];

            $this->sendEmail($user, $configTemplate, $configData, "Аккаунт зарегистрирован!");
        });
    }

    public function newUser(SignupForm $form): User
    {
        $user = User::requestSignup($form);
        return $user;
    }

    public function newProfile(ProfileCreateForm $form, $user_id): Profiles
    {
        $profile = Profiles::create($form, $user_id);
        return $profile;
    }

    public function newUserDod(DateDod $dateDod, $user_id, SignupDodForm $form): UserDod
    {
        if ($dateDod->isTypeIntramuralLiveBroadcast()) {
            $userDod = UserDod::create($dateDod->id, $user_id, $form->userTypeParticipation->form_of_participation);
        }elseif($dateDod->isTypeRemoteEdu()) {
            $userDod = UserDod::create($dateDod->id,
                $user_id,
                null,
                $form->statusDodUser->status_edu,
                $this->newOrRenameSchoolRegisterDodId($form, $this->dictSchoolsRepository),
                $form->statusDodUser->count);
        }else {
            $userDod = UserDod::create($dateDod->id, $user_id);
        }
        return $userDod;
    }

}