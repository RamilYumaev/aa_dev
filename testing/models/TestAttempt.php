<?php


namespace testing\models;


use testing\models\queries\TestAttemptQuery;
use yii\db\ActiveRecord;

class TestAttempt extends ActiveRecord
{
    const GOLD = 1;
    const SILVER = 2;
    const BRONZE = 3;
    const MEMBER = 4;

    public static function tableName()
    {
        return 'test_attempt';
    }

    public static function create ($test_id, $time) {
        $testAtt = new static();
        $testAtt->user_id = \Yii::$app->user->identity->getId();
        $testAtt->test_id = $test_id;
        $testAtt->start = self::time($time);
        $testAtt->end = null;
        return $testAtt;
    }

    private static function time($time)
    {
        $date =  date("Y-m-d H:i:s");
        $currentDate = strtotime($date);
        $futureDate = $currentDate+(60*$time);
        $formatDate = date("Y-m-d H:i:s", $futureDate);
        return $time ? $formatDate :  $date;
    }



    public function edit($mark) {
        $this->end = date("Y-m-d H:i:s");
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
}