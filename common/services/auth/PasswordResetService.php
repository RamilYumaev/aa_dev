<?php


namespace common\services\auth;

use common\forms\auth\PasswordResetRequestForm;
use common\forms\auth\ResetPasswordForm;
use common\repositories\UserRepository;
use common\transactions\TransactionManager;
use Yii;

class PasswordResetService
{
    private $users;
    private $transaction;

    public function __construct(
        UserRepository $users,
        TransactionManager $transaction
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
    }

    public function request(PasswordResetRequestForm $form): void
    {
        $user = $this->users->getByEmail($form->email);
        $user->requestPasswordReset();


        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            $this->sendEmail($user);
        });
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

    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Сброс пароля ' . Yii::$app->name)
            ->send();
    }
}
