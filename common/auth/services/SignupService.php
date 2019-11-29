<?php


namespace common\auth\services;

use common\auth\forms\UserEmailForm;
use common\helpers\FlashMessages;
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

    public function signup(SignupForm $form): User
    {
        $user = $this->newUser($form);
        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            $profile = $this->newProfile($user->id);
            $this->profileRepository->save($profile);
        });

        return $user;
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

    public function confirm($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException(FlashMessages::get()["verify_email_token_cannot_be_blank"]);
        }
        $user = $this->users->getByVerificationToken($token);
        $user->confirmSignup();
        $this->users->save($user);
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
            ->setSubject('Аккуант зарегистрирован!' . Yii::$app->name)
            ->send();
    }
}