<?php


namespace common\services\auth;

use Yii;
use common\auth\rbac\Rbac;
use common\auth\rbac\RoleManager;
use common\forms\auth\SignupForm;
use common\models\auth\User;
use common\repositories\UserRepository;
use common\transactions\TransactionManager;
use yii\base\InvalidArgumentException;

class SignupService
{
    private $users;
    private $roles;
    private $transaction;

    public function __construct(
        UserRepository $users,
        RoleManager $roles,
        TransactionManager $transaction
    )
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
            $this->sendEmail($user);
        });
    }


    public function confirm ($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }
        $user = $this->users->getByVerificationToken($token);
        $user->confirmSignup();
        $this->users->save($user);
    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail(User $user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Аккунт зарегистрирован!' . Yii::$app->name)
            ->send();
    }
}