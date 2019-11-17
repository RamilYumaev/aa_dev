<?php

namespace olympic\readRepositories;

use common\auth\helpers\UserHelper;
use common\auth\models\User;
use common\helpers\EduYearHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use olympic\models\UserOlimpiads;

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