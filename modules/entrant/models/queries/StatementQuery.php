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

    public function id($id)
    {
        return $this->andWhere(["id" =>$id]);
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

    public function statusNoDraft($alias = "")
    {
        return $this->andWhere([">", $alias."status", StatementHelper::STATUS_DRAFT]);
    }

    public function orderByCreatedAtDesc($alias = "")
    {
        return $this->orderBy([$alias.'created_at' => SORT_DESC]);
    }

    public function  formCategory($form) {
        return $this->andWhere(['form_category' => $form]);
    }


    public function eduLevel($eduLevel)
    {
        return $this->andWhere(["edu_level" =>$eduLevel]);
    }

    public function defaultWhere($facultyId, $specialityId, $specialRight, $eduLevel, $status, $formCategory) {
        return $this->faculty($facultyId)
            ->speciality($specialityId)
            ->specialRight($specialRight)
            ->eduLevel($eduLevel)
            ->status($status)
            ->formCategory($formCategory);
    }

    public function defaultWhereNoStatus($facultyId, $specialityId, $specialRight, $eduLevel, $formCategory) {
        return $this->faculty($facultyId)
            ->speciality($specialityId)
            ->specialRight($specialRight)
            ->eduLevel($eduLevel)
            ->formCategory($formCategory);
    }

    public function lastMaxCounter($facultyId, $specialityId, $specialRight, $eduLevel, $userId, $formCategory) {
        return $this->defaultWhereNoStatus($facultyId, $specialityId, $specialRight, $eduLevel, $formCategory)->user($userId)->max('counter');
    }

    public function statementUser($facultyId, $specialityId, $specialRight, $eduLevel, $status, $userId, $formCategory) {
        return $this->defaultWhere($facultyId, $specialityId, $specialRight, $eduLevel, $status, $formCategory)
            ->user($userId)
            ->one();
    }


}