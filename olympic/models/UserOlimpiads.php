<?php


namespace olympic\models;


class UserOlimpiads extends \yii\db\ActiveRecord
{
    private $_olimpicList;

    public function __construct($config = [])
    {
        $this->_olimpicList = new OlimpicList();
        parent::__construct($config);
    }

    public static function create($olympiads_id, $user_id)
    {
        $olimpicUser = new static();
        $olimpicUser->olympiads_id = $olympiads_id;
        $olimpicUser->user_id = $user_id;

        return $olimpicUser;
    }

    public function getOlympicOne() {
        return $this->_olimpicList->olympicListRelation($this->olympiads_id)->one();
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_olimpiads';
    }


}