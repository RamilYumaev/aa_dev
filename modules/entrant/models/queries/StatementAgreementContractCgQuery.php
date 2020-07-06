<?php
namespace modules\entrant\models\queries;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;

class StatementAgreementContractCgQuery extends \yii\db\ActiveQuery
{
    public function statement($id, $user_id) {
        return $this->alias('contractCg')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=contractCg.statement_cg')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'contractCg.id' => $id]);
    }

    public function statementUser($user_id) {
        return $this->alias('contractCg')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=contractCg.statement_cg')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id]);
    }

    public function statementUserCgId($user_id, $statementCgId) {
        return $this->alias('contractCg')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=contractCg.statement_cg')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'contractCg.statement_cg'=> $statementCgId]);
    }


    public function statementStatus($user_id, $status) {
        return $this->alias('contractCg')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=contractCg.statement_cg')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'contractCg.status_id' => $status,]);
    }

    public function statementOne($id, $user_id) {
        return $this->statement($id, $user_id)->one();
    }


    public function statusNoDraft($alias = '')
    {
        return $this->andWhere([">", $alias."status_id", StatementHelper::STATUS_DRAFT]);
    }

    public function orderByCreatedAtDesc()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }


}