<?php


namespace modules\entrant\repositories;


use modules\entrant\models\AdditionalInformation;
use modules\usecase\RepositoryDeleteSaveClass;

class AdditionalInformationRepository extends RepositoryDeleteSaveClass
{
    public function getUser($user_id): ?AdditionalInformation
    {
        return AdditionalInformation::findOne(['user_id'=> $user_id]);
    }

}