<?php


namespace dod\models;


class UserDod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_dod';
    }

    public static  function create ($dod_id, $user_id)
    {
        $userDod = new static();
        $userDod->dod_id = $dod_id;
        $userDod->user_id = $user_id;

        return $userDod;
    }
}