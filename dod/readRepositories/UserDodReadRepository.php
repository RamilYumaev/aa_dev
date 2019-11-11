<?php

namespace dod\readRepositories;

use dod\models\UserDod;

class UserDodReadRepository
{
    /**
     * @param $dod_id
     * @param $user_id
     * @return array|\yii\db\ActiveRecord|null
     */

    public function find($dod_id, $user_id): ?UserDod
    {
        $model = UserDod::findOne(['dod_id' => $dod_id, 'user_id' =>$user_id]);

        return  $model;
    }
}