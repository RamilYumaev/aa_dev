<?php


namespace modules\entrant\repositories;

use modules\entrant\models\StatementConsentCg;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementConsentCgRepository extends RepositoryDeleteSaveClass
{
    public function get($id)
    {
        if (!$model = StatementConsentCg::findOne($id)) {
            return false;
        }
        return  $model;
    }

}