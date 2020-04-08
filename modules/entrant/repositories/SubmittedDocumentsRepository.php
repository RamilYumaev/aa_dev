<?php


namespace modules\entrant\repositories;


use modules\entrant\models\SubmittedDocuments;
use modules\usecase\RepositoryDeleteSaveClass;

class SubmittedDocumentsRepository extends RepositoryDeleteSaveClass
{
    public function getUser($user_id): ?SubmittedDocuments
    {
        return SubmittedDocuments::findOne(['user_id'=> $user_id]);
    }

}