<?php
namespace modules\entrant\models\queries;


use modules\entrant\helpers\StatementHelper;

class StatementIAQuery extends \yii\db\ActiveQuery
{
    public function user($userId)
    {
        return $this->andWhere(["user_id" =>$userId]);
    }

    public function status($status)
    {
        return $this->andWhere(["status" => $status]);
    }

    public function eduLevel($eduLevel)
    {
        return $this->andWhere(["edu_level" =>$eduLevel]);
    }

    public function defaultWhere($eduLevel, $status) {
        return $this
            ->eduLevel($eduLevel)
            ->status($status);
    }

    public function lastMaxCounter($eduLevel, $userId) {
        return $this->eduLevel($eduLevel)->user($userId)->max('counter');
    }

    public function existsStatementIA($eduLevel, $userId) {
        return $this->user($userId)->eduLevel($eduLevel)->exists();
    }

    public function statementIAUser($eduLevel, $status, $userId) {
        return $this->defaultWhere($eduLevel, $status)
            ->user($userId)
            ->one();
    }

    public function statementIAUserOne($eduLevel, $userId) {
        return $this->eduLevel($eduLevel)
            ->user($userId)
            ->one();
    }

    public function statusNoDraft()
    {
        return $this->andWhere([">", "status", StatementHelper::STATUS_DRAFT]);
    }

    public function orderByCreatedAtDesc()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }


}