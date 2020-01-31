<?php


namespace olympic\services;

use common\helpers\FlashMessages;
use common\auth\forms\SignupForm;
use common\auth\models\UserSchool;
use common\sending\traits\MailTrait;
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
use olympic\traits\NewOrRenameSchoolTrait;
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

    use MailTrait;
    use NewOrRenameSchoolTrait;

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
        try {
            $this->transaction->wrap(function () use ($form) {

                $user = $this->newUser($form->user);
                $this->userRepository->save($user);

                $profile = $this->newProfile($form->profile, $user->id);
                $this->profileRepository->save($profile);

                $userSchool = $this->newUserSchool($this->newOrRenameSchoolRegisterOlympicId($form, $this->schoolsRepository), $form->schoolUser->class_id, $user->id);
                $this->userSchoolRepository->save($userSchool);

                $userOlympic = $this->newUserOlimpiads($form->idOlympic, $user->id);
                $this->userOlimpiadsRepository->save($userOlympic);

                $configTemplate = ['html' => 'emailVerifyOlympic-html', 'text' => 'emailVerifyOlympic-text'];
                $configData = ['user' => $user, 'olympic' => $userOlympic->olympiads_id];

                $this->sendEmail($user, $configTemplate, $configData, 'Аккаунт зарегистрирован! ');
                Yii::$app->session->setFlash('success', FlashMessages::get()["successRegistration"]);
            });
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error'," Ошибка сохранения");
        }
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
}