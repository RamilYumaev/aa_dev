<?php


namespace testing\models;


use olympic\models\OlimpicList;
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

    public static function create ($test_id, OlimpicList $olimpicList) {
        $testAtt = new static();
        $testAtt->user_id = \Yii::$app->user->identity->getId();
        $testAtt->test_id = $test_id;
        $testAtt->start = date("Y-m-d H:i:s" );
        $testAtt->end = self::time($olimpicList);
        return $testAtt;
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
}