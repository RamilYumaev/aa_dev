<?php
namespace modules\entrant\models\queries;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;

class StatementConsentCgQuery extends \yii\db\ActiveQuery
{
    public function statement($id, $user_id) {
        return $this->alias('consentCg')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=consentCg.statement_cg_id')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'consentCg.id' => $id]);
    }

    public function statementStatus($user_id, $status) {
        return $this->alias('consentCg')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=consentCg.statement_cg_id')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'consentCg.status' => $status]);
    }

    public function statementStatusBudget($user_id, $status) {
        return $this->alias('consentCg')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=consentCg.statement_cg_id')
            ->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=statement_cg.cg_id')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'consentCg.status' => $status,
                'financing_type_id'=>DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET]);
    }

    public function statementStatusAndCg($userId, $status, $cgId) {
        return $this->alias('consentCg')
            ->innerJoin(StatementCg::tableName(), 'statement_cg.id=consentCg.statement_cg_id')
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $userId, 'consentCg.status' => $status, 'statement_cg.cg_id'=> $cgId]);
    }

    public function statementOne($id, $user_id) {
        return $this->statement($id, $user_id)->one();
    }

    public function statusNoDraft($alias = '')
    {
        return $this->andWhere([">", $alias."status", StatementHelper::STATUS_DRAFT]);
    }

    public function status($status, $alias = '')
    {
        return $this->andWhere([$alias."status" => $status]);
    }
    public function orderByCreatedAtDesc()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }


}