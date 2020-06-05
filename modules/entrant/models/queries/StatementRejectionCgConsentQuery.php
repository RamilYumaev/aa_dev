<?php
namespace modules\entrant\models\queries;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;

class StatementRejectionCgConsentQuery extends \yii\db\ActiveQuery
{
    public function statement($id, $user_id) {
        return $this->alias('rejectionCg')
            ->innerJoin(StatementConsentCg::tableName(), 'statement_consent_cg.id=rejectionCg.statement_cg_consent_id')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=statement_consent_cg.statement_cg_id')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'rejectionCg.id' => $id]);
    }

    public function statementStatus($user_id, $status) {
        return $this->alias('consentCg')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=consentCg.statement_cg_id')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'consentCg.status' => $status]);
    }

    public function statementOne($id, $user_id) {
        return $this->statement($id, $user_id)->one();
    }

    public function statusNoDraft($alias = '')
    {
        return $this->andWhere([">", $alias."status", StatementHelper::STATUS_DRAFT]);
    }

    public function orderByCreatedAtDesc()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }


}