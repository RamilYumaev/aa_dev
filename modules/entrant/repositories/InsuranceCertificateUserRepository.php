<?php

namespace modules\entrant\repositories;

use modules\entrant\models\InsuranceCertificateUser;
use modules\usecase\RepositoryDeleteSaveClass;

class InsuranceCertificateUserRepository extends RepositoryDeleteSaveClass
{
    public function getUser($user_id): ?InsuranceCertificateUser
    {
        return InsuranceCertificateUser::findOne(['user_id'=> $user_id]);
    }
}