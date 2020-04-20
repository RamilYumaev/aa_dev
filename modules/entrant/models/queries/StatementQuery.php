<?php
namespace modules\entrant\models\queries;


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

    public function submitted($submitted)
    {
        return $this->andWhere(["submitted" => $submitted]);
    }

    public function eduLevel($eduLevel)
    {
        return $this->andWhere(["edu_level" =>$eduLevel]);
    }

    public function defaultWhere($facultyId, $specialityId, $specialRight, $eduLevel, $submitted) {
        return $this->faculty($facultyId)
            ->speciality($specialityId)
            ->specialRight($specialRight)
            ->eduLevel($eduLevel)
            ->submitted($submitted);
    }

    public function lastMaxCounter($facultyId, $specialityId, $specialRight, $eduLevel, $submitted) {
        return $this->defaultWhere($facultyId, $specialityId, $specialRight, $eduLevel, $submitted)->max('counter');
    }

    public function statementUser($facultyId, $specialityId, $specialRight, $eduLevel, $submitted, $userId) {
        return $this->defaultWhere($facultyId, $specialityId, $specialRight, $eduLevel, $submitted)
            ->user($userId)
            ->one();
    }


}