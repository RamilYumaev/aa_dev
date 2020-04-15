<?php


namespace modules\entrant\repositories;


use modules\entrant\models\CseViSelect;
use modules\usecase\RepositoryDeleteSaveClass;

class CseViSelectRepository extends RepositoryDeleteSaveClass
{
    public function getUser($user_id): ?CseViSelect
    {
        return CseViSelect::findOne(['user_id'=> $user_id]);
    }

}