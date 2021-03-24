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

    public function cseOrCt() {
        return $this->type([UserDiscipline::CSE, UserDiscipline::CT]);
    }


}