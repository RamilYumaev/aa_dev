<?php

namespace common\auth\repositories;

use common\auth\models\UserFirebaseToken;
use modules\usecase\RepositoryDeleteSaveClass;

class UserFirebaseTokenRepository extends RepositoryDeleteSaveClass
{
    public function get($userId, $token): ?UserFirebaseToken
    {
        return  UserFirebaseToken::findOne(['user_id' => $userId, 'token' => $token]);
    }

}