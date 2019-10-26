<?php


namespace olympic\models;


use yii\db\ActiveRecord;

class PersonalPresenceAttempt extends ActiveRecord
{

    public static function create($user_id, $olimpic_id, $mark, $presence_status, $reward_status)
    {
        $attempt = new static();
        $attempt->user_id = $user_id;
        $attempt->olimpic_id = $olimpic_id;
        $attempt->presence_status = $presence_status;
        $attempt->mark = $mark;
        $attempt->reward_status = $reward_status;
        return $attempt;

    }

    public static function tableName()
    {
        return 'personal_presence_attempt';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mark' => 'Оценка',
        ];
    }


}