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

    public function discipline($discipline)
    {
        return $this->andWhere(["discipline_id" => $discipline]);
    }

    public function disciplineSelect($discipline)
    {
        return $this->andWhere(["discipline_select_id" => $discipline]);
    }

    public function cseOrCt() {
        return $this->type([UserDiscipline::CSE, UserDiscipline::CT]);
    }

    public function cseOrCtAndVi() {
        return $this->type([UserDiscipline::CSE_VI, UserDiscipline::CT_VI]);
    }

    public function vi() {
        return $this->type([UserDiscipline::VI]);
    }



}