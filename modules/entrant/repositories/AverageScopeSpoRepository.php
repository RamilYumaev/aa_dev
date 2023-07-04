<?php


namespace modules\entrant\repositories;


use modules\entrant\models\AverageScopeSpo;
use modules\usecase\RepositoryDeleteSaveClass;

class AverageScopeSpoRepository extends RepositoryDeleteSaveClass
{
    public function getUser($user_id): ?AverageScopeSpo
    {
        return AverageScopeSpo::findOne(['user_id'=> $user_id]);
    }

}