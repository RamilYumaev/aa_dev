<?php


namespace common\auth\services;

use common\auth\forms\UserEmailForm;
use common\auth\Identity;
use common\auth\rbac\Rbac;
use common\sending\traits\SelectionCommitteeMailTrait;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\Profiles;
use olympic\repositories\auth\ProfileRepository;
use Yii;
use common\auth\forms\SignupForm;
use common\auth\models\User;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use yii\base\InvalidArgumentException;

class SignupService
{
    private $users;
    private $transaction;
    private $profileRepository;

    use SelectionCommitteeMailTrait;

    public function __construct(
        UserRepository $users,
        TransactionManager $transaction,
        ProfileRepository $profileRepository
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
        $this->profileRepository = $profileRepository;
    }

    public function signup(SignupForm $form, $role = null): void
    {
        $this->transaction->wrap(function () use ($form, $role) {
            $user = $this->newUser($form);
            $this->users->save($user);

            $profile = $this->newProfile($user->id);
            $profile->setRole($role);
            $this->profileRepository->save($profile);

            if($role !== ProfileHelper::ROLE_STUDENT) {
                $user->setAssignmentFirst(Rbac::roleName($role));
            }

            //$configTemplate =  ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'];
            //$configData = ['user' => $user];

            //$this->sendEmail($user, $configTemplate, $configData, "Аккаунт зарегистрирован!");

            Yii::$app->user->login(new Identity($user));
        });
    }

    public function newUser(SignupForm $form): User
    {
        $user = User::requestSignup($form);
        return $user;
    }

    public function newProfile($user_id): Profiles
    {
        $profile = Profiles::createDefault($user_id);
        return $profile;
    }

    public function addEmail(UserEmailForm $form)
    {
        $user = $this->users->get(Yii::$app->user->identity->getId());
        $user->addEmail($form);
        $this->users->save($user);
    }

    public function confirm($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Убедитесь, что токен электронной почты не может быть пустым.');
        }
        $user = $this->users->getByVerificationToken($token);
        $user->confirmSignup();
        $this->users->save($user);
        return $user;
    }
}