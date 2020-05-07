<?php


namespace modules\entrant\repositories;


use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\FIOLatin;
use modules\usecase\RepositoryDeleteSaveClass;

class FiOLatinRepository extends RepositoryDeleteSaveClass
{
    public function getUser($user_id): ?FIOLatin
    {
        return FIOLatin::findOne(['user_id'=> $user_id]);
    }

}