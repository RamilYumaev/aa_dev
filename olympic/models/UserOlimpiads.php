<?php


namespace olympic\models;


class UserOlimpiads extends \yii\db\ActiveRecord
{


    public static function create($olympiads_id, $user_id)
    {
        $olimpicUser = new static();
        $olimpicUser->olympiads_id = $olympiads_id;
        $olimpicUser->user_id = $user_id;

        return $olimpicUser;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_olimpiads';
    }


}