<?php


namespace modules\entrant\models\queries;


use yii\db\ActiveQuery;

class UserCgQuery extends ActiveQuery
{

    public function findUserAndCg($id)
    {
        return $this->andWhere(["user_id" => \Yii::$app->user->id, "cg_id" => $id]);
    }


}