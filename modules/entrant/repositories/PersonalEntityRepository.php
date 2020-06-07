<?php


namespace modules\entrant\repositories;


use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\FIOLatin;
use modules\entrant\models\PersonalEntity;
use modules\usecase\RepositoryDeleteSaveClass;

class PersonalEntityRepository extends RepositoryDeleteSaveClass
{
    public function getIdUser($id, $user_id): ?PersonalEntity
    {
        return PersonalEntity::findOne(['id' => $id,'user_id'=> $user_id]);
    }

}