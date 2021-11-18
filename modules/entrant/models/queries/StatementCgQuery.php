<?php
namespace modules\entrant\models\queries;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
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

    public function statementUserCgIdActualColumn($user_id, $formCategory) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id,  'status_id' => null,
                'statement.status' => StatementHelper::STATUS_ACCEPTED,
                'statement.form_category'=> $formCategory])->
            select(['cg_id'])->column();
    }

    public function statementUserCgIdActualLevelColumn($user_id, $eduLevel, $formCategory) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id,  'status_id' => null,
                'statement.status' => StatementHelper::STATUS_ACCEPTED,
                'statement.edu_level'=> $eduLevel,
                'statement.form_category'=> $formCategory])->
            select(['cg_id'])->column();
    }

    public function statementUserLevelCg($eduLevel, $formCategory, $finance = null){
        return $this
            ->joinWith('statement')
            ->andWhere(['status_id' => null,
                'statement.edu_level'=> $eduLevel,
                'statement.form_category'=> $formCategory,
                'statement.finance'=> $finance ?? [1,2],
                'statement.status' => StatementHelper::STATUS_ACCEPTED])
            ->select('user_id')->distinct()->orderBy(['user_id'=> SORT_ASC])->column();
    }

    public function statementUserCgIdsColumn($user_id, $cgIds) {
        return $this
            ->innerJoin(Statement::tableName(), 'statement.id=statement_cg.statement_id')
            ->andWhere(['statement.user_id' => $user_id,  'status_id' => null,
                'statement.status' => StatementHelper::STATUS_ACCEPTED,
                'cg_id'=> $cgIds])->select(['cg_id'])->all();
    }



}