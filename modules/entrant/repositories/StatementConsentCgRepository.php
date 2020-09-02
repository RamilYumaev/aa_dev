<?php
namespace modules\entrant\repositories;

use modules\entrant\helpers\StatementHelper;
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

    public function getFull($id, $userId)
    {
        if (!$model = StatementConsentCg::find()->statementOne($id, $userId)) {
            throw new \DomainException('Заявление о согласии на зачисление не найдено.');
        }
        return  $model;
    }

    public function exits($userId, $status)
    {
       return StatementConsentCg::find()->statementStatusBudget($userId, $status)->exists();
    }

    public function exitsCg($userId, $status, $cgId)
    {
        return StatementConsentCg::find()->statementStatusAndCg($userId, $status, $cgId)->exists();
    }

    public function oneAcceptedCg($userId, $cgId)
    {
        return StatementConsentCg::find()->statementStatusAndCg($userId, StatementHelper::STATUS_ACCEPTED, $cgId)->one();
    }

}