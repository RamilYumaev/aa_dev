<?php


namespace modules\entrant\models\queries;


use modules\entrant\models\UserDiscipline;
use yii\db\ActiveQuery;

class UserDisciplineQuery extends ActiveQuery
{

    public function type($type)
    {
        return $this->andWhere(['type'=> $type]);
    }

    public function user($user)
    {
        return $this->andWhere(["user_id" =>$user]);
    }

    public function year($year)
    {
        return $this->andWhere(["year" =>$year]);
    }

    public function status($status)
    {
        return $this->andWhere(["status_cse" => $status]);
    }

    public function discipline($discipline)
    {
        return $this->andWhere(["discipline_id" => $discipline]);
    }

    public function disciplineSelect($discipline)
    {
        return $this->andWhere(["discipline_select_id" => $discipline]);
    }

    public function typeCse()
    {
        return $this->type([UserDiscipline::CSE, UserDiscipline::CSE_VI]);
    }

    public function statusNoFound()
    {
        return $this->status(UserDiscipline::STATUS_NOT_FOUND);
    }

    public function cseOrCt() {
        return $this->type([UserDiscipline::CSE, UserDiscipline::CT]);
    }

    public function cseOrCtAndVi() {
        return $this->type([UserDiscipline::CSE_VI, UserDiscipline::CT_VI]);
    }

    public function cseOrVi() {
        return $this->type([UserDiscipline::CSE, UserDiscipline::CSE_VI]);
    }

    public function ctOrVi() {
        return $this->type([UserDiscipline::CT, UserDiscipline::CT_VI]);
    }

    public function vi() {
        return $this->type([UserDiscipline::VI]);
    }



}