<?php

namespace modules\entrant\models\queries;


use yii\db\ActiveQuery;

class AnketaQuery extends ActiveQuery
{

    public function userAnketa($user)
    {
        return $this->andWhere(['user_id' => $user]);
    }


}