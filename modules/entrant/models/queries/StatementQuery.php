<?php
namespace modules\entrant\models\queries;


use modules\entrant\helpers\StatementHelper;

class StatementQuery extends \yii\db\ActiveQuery
{
    public function user($userId)
    {
        return $this->andWhere(["user_id" =>$userId]);
    }

    public function faculty($facultyId)
    {
        return $this->andWhere(["faculty_id" =>$facultyId]);
    }

    public function speciality($specialityId)
    {
        return $this->andWhere(["speciality_id" => $specialityId]);
    }

    public function specialRight($specialRight)
    {
        return $this->andWhere(["special_right" =>$specialRight]);
    }

    public function status($status)
    {
        return $this->andWhere(["status" => $status]);
    }

    public function statusNoDraft()
    {
        return $this->andWhere([">", "status", StatementHelper::STATUS_DRAFT]);
    }

    public function orderByCreatedAtDesc()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }


    public function eduLevel($eduLevel)
    {
        return $this->andWhere(["edu_level" =>$eduLevel]);
    }

    public function defaultWhere($facultyId, $specialityId, $specialRight, $eduLevel, $status) {
        return $this->faculty($facultyId)
            ->speciality($specialityId)
            ->specialRight($specialRight)
            ->eduLevel($eduLevel)
            ->status($status);
    }

    public function defaultWhereNoStatus($facultyId, $specialityId, $specialRight, $eduLevel) {
        return $this->faculty($facultyId)
            ->speciality($specialityId)
            ->specialRight($specialRight)
            ->eduLevel($eduLevel);
    }

    public function lastMaxCounter($facultyId, $specialityId, $specialRight, $eduLevel, $userId) {
        return $this->defaultWhereNoStatus($facultyId, $specialityId, $specialRight, $eduLevel)->user($userId)->max('counter');
    }

    public function statementUser($facultyId, $specialityId, $specialRight, $eduLevel, $status, $userId) {
        return $this->defaultWhere($facultyId, $specialityId, $specialRight, $eduLevel, $status)
            ->user($userId)
            ->one();
    }


}