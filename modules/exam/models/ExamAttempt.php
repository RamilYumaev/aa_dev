<?php


namespace modules\exam\models;


use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\OlimpicList;
use testing\helpers\TestAttemptHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exam_attempt}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $exam_id
 * @property integer $test_id
 * @property string $start
 * @property string $end
 * @property integer $status
 * @property integer $mark
 *
 **/

class ExamAttempt extends ActiveRecord
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


    public function seStatus($status)
    {
        $this->status = $status;
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

    public function  isMarkNull() {
        return $this->mark == null;
    }


    public function  isAttemptEnd() {
        return $this->status == TestAttemptHelper::END_TEST;
    }

    public function  isAttemptNoEnd() {
        return $this->status == TestAttemptHelper::NO_END_TEST;
    }


}