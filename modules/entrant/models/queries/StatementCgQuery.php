<?php
namespace modules\entrant\models\queries;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;

class StatementCgQuery extends \yii\db\ActiveQuery
{
    public function statement($id, $user_id) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'statement_cg.id' => $id]);
    }

    public function statementOne($id, $user_id) {
        return $this->statement($id, $user_id)->one();
    }



}