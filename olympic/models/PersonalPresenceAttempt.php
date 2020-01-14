<?php


namespace olympic\models;


use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\queries\OlimpicQuery;
use olympic\models\queries\PersonalPresenceAttemptQuery;
use yii\db\ActiveRecord;

class PersonalPresenceAttempt extends ActiveRecord
{

    public function setMark($mark)
    {
        $this->mark = $mark;
    }

    public function setRewardStatus($status)
    {
        $this->reward_status = $status;
    }

    public function setPresenceStatus($status)
    {
        $this->presence_status = $status;
    }

    public function setNomination($nomination)
    {
        $this->nomination_id = $nomination;
    }

    public static function defaultCreate($user_id, $olimpic_id)
    {
        $attempt = new static();
        $attempt->user_id = $user_id;
        $attempt->olimpic_id = $olimpic_id;
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

    public static function find(): PersonalPresenceAttemptQuery
    {
        return new PersonalPresenceAttemptQuery(static::class);
    }

    public function  isNonAppearance() {
        return $this->presence_status == PersonalPresenceAttemptHelper::NON_APPEARANCE;
    }

    public function  isPresence() {
        return $this->presence_status == PersonalPresenceAttemptHelper::PRESENCE;
    }

    public function  isPresenceStatusNull() {
        return is_null($this->presence_status);
    }

    public function  isRewardStatusNull() {
        return $this->reward_status === null;
    }

    public function  isMarkNull() {
        return $this->mark == null;
    }

    public function  isBallInMark () {
        return $this->mark > 0;
    }

    public function  ballFirstPlace () {
        return $this->mark >= PersonalPresenceAttemptHelper::MIN_BALL_FIRST_PLACE;
    }

    public function  ballNoFirstPlace () {
        return $this->mark >= PersonalPresenceAttemptHelper::MIN_BALL_NO_FIRST_PLACE;
    }

    public function  isRewardFirstPlace() {
        return $this->reward_status == PersonalPresenceAttemptHelper::FIRST_PLACE;
    }

    public function  isRewardSecondPlace() {
        return $this->reward_status == PersonalPresenceAttemptHelper::SECOND_PLACE;
    }

    public function  isRewardThirdPlace() {
        return $this->reward_status == PersonalPresenceAttemptHelper::THIRD_PLACE;
    }

    public function isNullNomination()
    {
        return $this->nomination_id === null;
    }





}