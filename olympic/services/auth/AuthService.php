<?php
namespace olympic\services\auth;

use olympic\forms\auth\LoginForm;
use olympic\models\auth\User;
use olympic\repositories\auth\UserRepository;

class AuthService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->repository->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Неверный логин или пароль.');
        }
        return $user;
    }
}