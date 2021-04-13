<?php

namespace common\auth\repositories;

use common\auth\models\UserSdoToken;
use modules\usecase\RepositoryDeleteSaveClass;

class UserSdoTokenRepository extends RepositoryDeleteSaveClass
{
    public function get($userId): ?UserSdoToken
    {
        return  UserSdoToken::findOne($userId);
    }


}