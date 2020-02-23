<?php

namespace common\auth\repositories;

use common\auth\models\User;

class UserRepository
{
    public function findByUsernameOrEmail($value): ?User
    {
        return \common\auth\models\User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    public function save(User $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(\common\auth\models\User $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

    private function getBy(array $condition): User
    {
        if (!$user = \common\auth\models\User::find()->andWhere($condition)->limit(1)->one()) {
            throw new \DomainException('Такого пользователя нет.');
        }
        return $user;
    }

    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByVerificationToken($token): User
    {
        return $this->getBy(['verification_token' => $token]);
    }

    public function getByEmail($email): User
    {
        return $this->getBy(['email' => $email]);
    }

    public function getEmail($email): ?User
    {
        return  \common\auth\models\User::find()->andWhere(['email' => $email])->limit(1)->one();
    }

    public function getUsername($email): ?User
    {
        return  \common\auth\models\User::find()->andWhere(['username' => $email])->limit(1)->one();
    }


    public function getByPasswordResetToken($token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool)User::findByPasswordResetToken($token);
    }


}