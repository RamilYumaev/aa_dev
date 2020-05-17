<?php
namespace modules\entrant\models\queries;


use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;

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

    public function statementOne($id, $user_id) {
        return $this->statement($id, $user_id)->one();
    }


}