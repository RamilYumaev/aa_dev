<?php
namespace modules\entrant\models\queries;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;

class ReceiptContractCgQuery extends \yii\db\ActiveQuery
{
    public function receipt($id, $user_id) {
        return $this->alias('receipt')
            ->innerJoin(StatementAgreementContractCg::tableName(), 'statement_agreement_contract_cg.id=receipt.contract_cg_id')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=statement_agreement_contract_cg.statement_cg')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'receipt.id' => $id]);
    }

    public function receiptOne($id, $user_id) {
        return $this->receipt($id, $user_id)->one();
    }



}