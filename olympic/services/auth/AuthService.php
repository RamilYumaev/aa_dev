<?php

namespace olympic\services\auth;

use olympic\forms\auth\LoginForm;
use common\auth\models\User;
use common\auth\repositories\UserRepository;

class AuthService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function auth(LoginForm $form): \common\auth\models\User
    {
        $user = $this->repository->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Неверный логин или пароль.');
        }
        return $user;
    }

    public function autRbac(LoginForm $form): \common\auth\models\User
    {
        $user = $this->repository->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Неверный логин или пароль.');
        }
        if (!\Yii::$app->authManager->getPermissionsByUser($user->id)) {
            throw new \DomainException('У вас нет прав для входа.');
        }
        return $user;
    }
}