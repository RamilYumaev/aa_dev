<?php
namespace olympic\readRepositories;

use olympic\helpers\auth\UserHelper;
use olympic\models\auth\User;

class UserReadRepository
{
    public function find($id): ?User
    {
        return User::findOne($id);
    }

    public function findActiveByUsername($username): ?User
    {
        return User::findOne(['username' => $username, 'status' => UserHelper::STATUS_ACTIVE]);
    }

    public function findActiveById($id): ?User
    {
        return User::findOne(['id' => $id, 'status' => UserHelper::STATUS_ACTIVE]);
    }
}