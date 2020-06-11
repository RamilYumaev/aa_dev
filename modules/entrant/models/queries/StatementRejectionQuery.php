<?php
namespace modules\entrant\models\queries;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;

class StatementRejectionQuery extends \yii\db\ActiveQuery
{
    public function statement($id, $user_id) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_rejection.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'statement_rejection.id' => $id]);
    }

    public function statementOne($id, $user_id) {
        return $this->statement($id, $user_id)->one();
    }

    public function statementStatus($user_id, $status) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_rejection.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'statement_rejection.status_id' => $status]);
    }

    public function statusNoDraft($alias = "")
    {
        return $this->andWhere([">", $alias."status_id", StatementHelper::STATUS_DRAFT]);
    }

    public function orderByCreatedAtDesc($alias = "")
    {
        return $this->orderBy([$alias.'created_at' => SORT_DESC]);
    }







}