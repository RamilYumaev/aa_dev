<?php


namespace testing\models;


use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\OlimpicList;
use testing\helpers\TestAttemptHelper;
use testing\models\queries\TestAttemptQuery;
use yii\db\ActiveRecord;

class TestAttempt extends ActiveRecord
{

    public static function tableName()
    {
        return 'test_attempt';
    }

    public static function create ($test_id, OlimpicList $olimpicList) {
        $testAtt = new static();
        $testAtt->user_id = \Yii::$app->user->identity->getId();
        $testAtt->test_id = $test_id;
        $testAtt->start = date("Y-m-d H:i:s" );
        $testAtt->end = self::time($olimpicList);
        return $testAtt;
    }

    public function setRewardStatus($status)
    {
        $this->reward_status = $status;
    }

    public function seStatus($status)
    {
        $this->status = $status;
    }

    public function setNomination($nomination)
    {
        $this->nomination_id = $nomination;
    }

    private static function time(OlimpicList $olimpicList)
    {
        $date = date("Y-m-d H:i:s");
        $time = $olimpicList->time_of_distants_tour ?? 0;
        if ($time) {
            $time = $time * 60;
            $currentDate = strtotime($date);
            $futureDate =  $currentDate + ($time);
            $formatDate = date("Y-m-d H:i:s", $futureDate);
        } else {
            $formatDate = $olimpicList->date_time_finish_reg;
        }
        return $formatDate;
    }

    public function edit($mark) {
        $this->mark = $mark;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'start' => 'Начало',
            'end' => 'Окончание',
            'test_id' => 'Тест',
            'mark' => 'Результат',
        ];
    }

    public static function find(): TestAttemptQuery
    {
        return new  TestAttemptQuery(static::class);
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

    public function  ballGold () {
        return $this->mark >= TestAttemptHelper::MIN_BALL_GOLD;
    }

    public function  ballNoGold () {
        return $this->mark >= TestAttemptHelper::MIN_BALL_NO_GOLD;
    }

    public function  isRewardGold() {
        return $this->reward_status == TestAttemptHelper::GOLD;
    }

    public function  isRewardSilver() {
        return $this->reward_status == TestAttemptHelper::SILVER;
    }

    public function  isRewardNoGold() {
        return $this->isRewardBronze()|| $this->isRewardSilver();
    }

    public function  isRewardBronze() {
        return $this->reward_status == TestAttemptHelper::BRONZE;
    }

    public function  isRewardMember() {
        return $this->reward_status == TestAttemptHelper::MEMBER;
    }

    public function  isAttemptEnd() {
        return $this->status == TestAttemptHelper::END_TEST;
    }

    public function  isAttemptNoEnd() {
        return $this->status == TestAttemptHelper::NO_END_TEST;
    }

    public function isNullNomination()
    {
        return $this->nomination_id === null;
    }

}