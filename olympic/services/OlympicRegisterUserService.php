<?php


namespace olympic\services;

use common\auth\forms\SignupForm;
use common\auth\models\UserSchool;
use olympic\repositories\UserOlimpiadsRepository;
use common\auth\repositories\UserRepository;
use common\auth\repositories\UserSchoolRepository;
use common\transactions\TransactionManager;
use dictionary\models\DictSchools;
use dictionary\repositories\DictClassRepository;
use dictionary\repositories\DictSchoolsRepository;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\SignupOlympicForm;
use olympic\models\UserOlimpiads;
use olympic\repositories\auth\ProfileRepository;
use olympic\repositories\OlimpicListRepository;
use olympic\models\auth\Profiles;
use common\auth\models\User;
use Yii;


class OlympicRegisterUserService
{
    private $olimpicListRepository;
    private $transaction;
    private $userRepository;
    private $profileRepository;
    private $userSchoolRepository;
    private $userOlimpiadsRepository;
    private $schoolsRepository;
    private $classRepository;

    public function __construct(
        DictClassRepository $classRepository,
        DictSchoolsRepository $schoolsRepository,
        UserSchoolRepository $userSchoolRepository,
        UserRepository $userRepository,
        ProfileRepository $profileRepository,
        OlimpicListRepository $olimpicListRepository,
        UserOlimpiadsRepository $userOlimpiadsRepository,
        TransactionManager $transaction
    )
    {
        $this->userSchoolRepository = $userSchoolRepository;
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
        $this->olimpicListRepository = $olimpicListRepository;
        $this->transaction = $transaction;
        $this->schoolsRepository = $schoolsRepository;
        $this->userOlimpiadsRepository = $userOlimpiadsRepository;
        $this->classRepository = $classRepository;
    }

    public function signup(SignupOlympicForm $form): void
    {
        $this->transaction->wrap(function () use ($form) {

            $user = $this->newUser($form->user);
            $this->userRepository->save($user);

            $profile = $this->newProfile($form->profile, $user->id);
            $this->profileRepository->save($profile);

            $userSchool = $this->newUserSchool($this->newOrRenameSchoolId($form), $form->schoolUser->class_id, $user->id);
            $this->userSchoolRepository->save($userSchool);

            $userOlympic = $this->newUserOlimpiads($form->idOlympic, $user->id);
            $this->userOlimpiadsRepository->save($userOlympic);

            $this->sendEmail($user);
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

    public function newUserSchool($school_id, $class_id, $user_id): UserSchool
    {
        $class = $this->classRepository->get($class_id);
        $userSchool = UserSchool::create($school_id, $user_id, $class->id);
        return $userSchool;
    }

    public function newUserOlimpiads($olympic_id, $user_id): UserOlimpiads
    {
        $olympic = $this->olimpicListRepository->get($olympic_id);
        $userOlympic = UserOlimpiads::create($olympic->id, $user_id);
        return $userOlympic;
    }

     public  function newOrRenameSchoolId(SignupOlympicForm $form) : int
     {
         $userSchoolForm =  $form->schoolUser;
         $profileForm = $form->profile;
         if($userSchoolForm->check_region_and_country_school &&
             $userSchoolForm->check_new_school &&
             $userSchoolForm->new_school) {
             $this->schoolsRepository->getFull($userSchoolForm->new_school,  $profileForm->country_id, $profileForm->region_id);
             $school = DictSchools::create($userSchoolForm->new_school,  $profileForm->country_id, $profileForm->region_id);
         } elseif (!$userSchoolForm->check_region_and_country_school &&
             $userSchoolForm->check_new_school &&
             $userSchoolForm->new_school) {
             $this->schoolsRepository->getFull($userSchoolForm->new_school, $userSchoolForm->country_school, $userSchoolForm->region_school);
             $school = DictSchools::create($userSchoolForm->new_school,  $userSchoolForm->country_school, $userSchoolForm->region_school);
         } elseif ($userSchoolForm->check_region_and_country_school &&
             $userSchoolForm->check_rename_school &&
             $userSchoolForm->new_school) {
             $school = $this->schoolsRepository->get($userSchoolForm->school_id);
             $school->edit($userSchoolForm->new_school, $profileForm->conutry_id, $profileForm->region_id);
         } elseif (!$userSchoolForm->check_region_and_country_school &&
             $userSchoolForm->check_rename_school &&
             $userSchoolForm->new_school) {
             $school = $this->schoolsRepository->get($userSchoolForm->school_id);
             $school->edit($userSchoolForm->new_school, $userSchoolForm->country_school, $userSchoolForm->region_school);
         } else {
             $school = $this->schoolsRepository->get($userSchoolForm->school_id);
         }
         $this->schoolsRepository->save($school);
         return $school->id;
     }


    /**
     * Sends confirmation email to user
     * @param \common\auth\models\User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public function sendEmail(User $user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Активация аккаунта. ' . Yii::$app->name)
            ->send();
    }

}