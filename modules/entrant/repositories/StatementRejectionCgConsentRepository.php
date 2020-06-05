<?php


namespace modules\entrant\repositories;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementRejectionCgConsentRepository extends RepositoryDeleteSaveClass
{
    public function getIdUser($id, $user): ?StatementRejectionCgConsent
    {
        if (!$model= StatementRejectionCgConsent::find()->statementOne($id, $user)) {
            throw new \DomainException('Заявление не найдено!');
        }
        return  $model;
    }

    public function get($id): ?StatementRejectionCgConsent
    {
        if (!$model= StatementRejectionCgConsent::findOne($id)) {
            throw new \DomainException('Заявление не найдено!');
        }
        return  $model;
    }

    public function isStatementConsentRejection($id)
    {
        if (StatementRejectionCgConsent::findOne(['statement_cg_consent_id'=>$id])) {
            throw new \DomainException('Заявление создано!');
        }
    }


}