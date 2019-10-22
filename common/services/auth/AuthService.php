<?php
namespace common\services\auth;

use common\forms\auth\LoginForm;
use common\models\auth\User;
use common\repositories\UserRepository;

class AuthService
{
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Неверный логин или пароль.');
        }
        return $user;
    }



}