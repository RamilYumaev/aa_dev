<?php
namespace modules\entrant\repositories;

use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementConsentCg;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementAgreementContractCgRepository extends RepositoryDeleteSaveClass
{
    public function get($id)
    {
        if (!$model = StatementAgreementContractCg::findOne($id)) {
            return false;
        }
        return  $model;
    }

    public function getFull($id, $userId)
    {
        if (!$model = StatementAgreementContractCg::find()->statementOne($id, $userId)) {
            throw new \DomainException('Договор не найден.');
        }
        return  $model;
    }

    public function exits($userId, $statementCgId)
    {
       return StatementAgreementContractCg::find()->statementUserCgId($userId, $statementCgId)->exists();
    }


}