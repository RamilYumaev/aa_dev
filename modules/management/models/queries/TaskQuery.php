<?php

namespace modules\management\models\queries;

use yii\db\ActiveQuery;

class TaskQuery extends ActiveQuery
{
    public function status($status)
    {
        return $this->andWhere(['status'=> $status]);
    }

    public function userResponsible($userId)
    {
        return $this->andWhere(['responsible_user_id'=> $userId]);
    }

}