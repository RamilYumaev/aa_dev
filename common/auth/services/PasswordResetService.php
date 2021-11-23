<?php


namespace common\auth\services;

use common\auth\forms\PasswordResetRequestForm;
use common\auth\forms\ResetPasswordForm;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use modules\student\forms\MultiResetForm;
use olympic\repositories\auth\ProfileRepository;
use olympic\services\auth\ProfileService;
use Yii;

class PasswordResetService
{
    private $users;
    private $transaction;
    private $profileRepository;

    public function __construct(
        UserRepository $users,
        ProfileRepository $profileRepository,
        TransactionManager $transaction
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
        $this->profileRepository = $profileRepository;
    }

    public function requestApi(MultiResetForm $form): void
    {
        $this->transaction->wrap(function () use ($form) {
            switch ($form->getScenario()) {
                case MultiResetForm::SCENARIO_PHONE:
                  $profile =  $this->profileRepository->getPhone($form->value);
                  $email = $profile->user->email;
                  break;
                case  MultiResetForm::SCENARIO_LOGIN:
                    $user = $this->users->findByUsernameOrEmail($form->value);
                    if(!$user) {
                        throw new \DomainException("Логин не найден");
                    }
                    $email = $user->email;
                    break;
                default:
                    $email = $form->value;
                    break;
            }
            $user = $this->requestPassword($email);
            $this->users->save($user);
            $this->sendEmail($user);
        });
    }

    public function request(PasswordResetRequestForm $form): void
    {
        $this->transaction->wrap(function () use ($form) {
            $user = $this->requestPassword($form->email);
            $this->users->save($user);
            $this->sendEmail($user);
        });
    }

    public function requestPassword($email)
    {
        $user = $this->users->getByEmail($email);
        $user->requestPasswordReset();
        return $user;
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        if (!$this->users->existsByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }

    public function sendEmail($user)
    {
        $mailer = Yii::$app->olympicMailer;
        return $mailer
            ->mailer()
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )->setFrom([$mailer->getFromSender() => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Сброс пароля ' . Yii::$app->name)
            ->send();
    }
}
