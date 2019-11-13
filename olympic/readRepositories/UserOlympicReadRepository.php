<?php
namespace olympic\readRepositories;

use olympic\models\UserOlimpiads;

class UserOlympicReadRepository
{
    /**
     * @param $olympic_id
     * @param $user_id
     * @return array|\yii\db\ActiveRecord|null
     */

    public function find($olympic_id, $user_id): ?UserOlimpiads
    {
        $model = UserOlimpiads::findOne(['olympiads_id' => $olympic_id, 'user_id' => $user_id]);

        return  $model;
    }
}