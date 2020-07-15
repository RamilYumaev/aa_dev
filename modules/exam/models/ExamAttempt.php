<?php


namespace modules\exam\models;


use modules\exam\models\queries\ExamAttemptQuery;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\OlimpicList;
use testing\helpers\TestAttemptHelper;
use testing\models\queries\TestAttemptQuery;
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
        return '{{%exam_attempt}}';
    }

    public static function create ($test_id, $exam) {
        $testAtt = new static();
        $testAtt->user_id = \Yii::$app->user->identity->getId();
        $testAtt->test_id = $test_id;
        $testAtt->exam_id = $exam;
        $testAtt->start = date("Y-m-d H:i:s" );
        $testAtt->end = "2025-04-02 14:44:00";
        return $testAtt;
    }

    public function seStatus($status)
    {
        $this->status = $status;
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

    public static function find(): ExamAttemptQuery
    {
        return new  ExamAttemptQuery(static::class);
    }



}