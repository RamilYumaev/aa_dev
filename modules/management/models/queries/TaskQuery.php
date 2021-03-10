<?php

namespace modules\management\models\queries;

use yii\db\ActiveQuery;

class TaskQuery extends ActiveQuery
{
    public function status($status)
    {
        return $this->andWhere(['status'=> $status]);
    }

    public function user($userId, $key = 'responsible_user_id')
    {
        return $this->andWhere([$key => $userId]);
    }

}