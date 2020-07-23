<?php
namespace modules\entrant\models\queries;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;

class StatementCgQuery extends \yii\db\ActiveQuery
{
    public function statement($id, $user_id) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'statement_cg.id' => $id]);
    }

    public function statementStatus($user_id, $status) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id, 'statement_cg.status_id' => $status]);
    }

    public function statementAcceptedStatus($cg_id) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement_cg.cg_id' => $cg_id, 'status_id' => null,
                'statement.status' => StatementHelper::STATUS_ACCEPTED]);
    }

    public function statementConsentAcceptedStatus($cg_id) {
        return $this
            ->innerJoin(StatementConsentCg::tableName(), 'statement_consent_cg.statement_cg_id=statement_cg.id')
            ->andWhere(['statement_cg.cg_id' => $cg_id, 'statement_consent_cg.status' => StatementHelper::STATUS_ACCEPTED]);
    }

    public function statementOne($id, $user_id) {
        return $this->statement($id, $user_id)->one();
    }

    public function statementUserCgIdActualColumn($user_id) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id,  'status_id' => null,
                'statement.status' => StatementHelper::STATUS_ACCEPTED])->
            select(['cg_id'])->column();
    }

    public function statementUserCg($eduLevel, $formCategory) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere([ 'status_id' => null,
                'statement.edu_level'=> $eduLevel,
                'statement.form_category'=> $formCategory,
                'statement.status' => StatementHelper::STATUS_ACCEPTED])->select(['cg_id'])->column();
    }




}