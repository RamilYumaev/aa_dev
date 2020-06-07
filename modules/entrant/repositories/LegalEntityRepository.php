<?php


namespace modules\entrant\repositories;


use modules\entrant\models\LegalEntity;
use modules\usecase\RepositoryDeleteSaveClass;

class LegalEntityRepository extends RepositoryDeleteSaveClass
{
    public function getIdUser($id, $user_id): ?LegalEntity
    {
        return LegalEntity::findOne(['id' => $id,'user_id'=> $user_id]);
    }

}