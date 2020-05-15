<?php


namespace modules\entrant\repositories;

use modules\entrant\models\StatementConsentPersonalData;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementPersonalDataRepository extends RepositoryDeleteSaveClass
{
    public function get($user_id)
    {
        if (!$model = StatementConsentPersonalData::findOne(['user_id'=>$user_id])) {
            return false;
        }
        return  $model;
    }

}