<?php


namespace modules\exam\models;


use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Anketa;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\queries\ExamAttemptQuery;
use olympic\models\auth\Profiles;
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
 * @property integer $type
 * @property integer $pause_minute
 *
 **/

class ExamAttempt extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%exam_attempt}}';
    }

    public static function create ($test_id, ExamStatement $examStatement) {
        $testAtt = new static();
        $testAtt->user_id = \Yii::$app->user->identity->getId();
        $testAtt->test_id = $test_id;
        $testAtt->exam_id = $examStatement->exam_id;
        $testAtt->start = date("Y-m-d H:i:s");
        $testAtt->end = $testAtt->time($examStatement);
        $testAtt->type = $examStatement->type;
        return $testAtt;
    }

    public static function createDefault ($test_id, $exam, $type = 0) {
        $testAtt = new static();
        $testAtt->user_id = \Yii::$app->user->identity->getId();
        $testAtt->test_id = $test_id;
        $testAtt->exam_id = $exam;
        $testAtt->start = date("Y-m-d H:i:s");
        $currentDate = strtotime($testAtt->start);
        $futureDate =  $currentDate + (300*60);
        $testAtt->end = date("Y-m-d H:i:s", $futureDate);
        $testAtt->type = $type;
        return $testAtt;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setMinute($minute)
    {
        $this->pause_minute = $minute;
    }

    private function time(ExamStatement $examStatement, $timePause = null)
    {
        $date = date("Y-m-d H:i:s");
        $time = $examStatement->exam->time_exam;
        if($this->information->voz_id) {
            $time = $timePause ? ((90+$time) * 60)-$timePause : (90+$time) * 60 ;
        }else {
            $time = $timePause ? ($time * 60)-$timePause : $time * 60;
        }
        $currentDate = strtotime($date);
        $futureDate =  $currentDate + ($time);
        if ($examStatement->type == 0)  {
         $examDateEnd = strtotime($examStatement->exam->dateTimeEndExam);
             if($futureDate > $examDateEnd) {
                 $formatDate = $examStatement->exam->dateTimeEndExam;
             } else {
                 $formatDate = date("Y-m-d H:i:s", $futureDate);
             }
        }else if($examStatement->type == 1) {
            $examDateEnd = strtotime($examStatement->exam->dateTimeReserveEndExam);
            if($futureDate > $examDateEnd) {
                $formatDate = $examStatement->exam->dateTimeReserveEndExam;
            } else {
                $formatDate = date("Y-m-d H:i:s", $futureDate);
            }
        } else {
            $examDateEnd = strtotime($examStatement->date." ".$examStatement->exam->timeEnd);
            if($futureDate > $examDateEnd) {
                $formatDate = $examStatement->date." 18:00:00";
            } else {
                $formatDate = date("Y-m-d H:i:s", $futureDate);
            }
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
            'user_id' => 'Абитуриент',
            'start' => 'Начало',
            'end' => 'Окончание',
            'test_id' => 'Тест',
            'mark' => 'Результат',
            'type' => "Тип",
            'typeName' => "Тип"
        ];
    }
    public function  isMarkNull() {
        return $this->mark == null;
    }

    public function addMinute()
    {
        $old = $this->pause_minute;
        $start = strtotime($this->start);
        $current = strtotime(date('Y-m-d H:i:s'));
        $this->pause_minute = ($current - $start) + $old;
    }

    public function start(ExamStatement $examStatement)
    {
        $this->start =date('Y-m-d H:i:s');
        $this->end = $this->time($examStatement, $this->pause_minute);
    }


    public function  isAttemptEnd() {
        return $this->status == TestAttemptHelper::END_TEST;
    }

    public function  isAttemptPause() {
        return $this->status == TestAttemptHelper::PAUSE_TEST;
    }

    public function  getTypeName() {
        return ExamStatementHelper::listTypes()[$this->type];
    }

    public function  isAttemptNoEnd() {
        return $this->status == TestAttemptHelper::NO_END_TEST;
    }

    public function  getInformation() {
        return $this->hasOne(AdditionalInformation::class, ['user_id'=>'user_id']);
    }

    public function  getProfile() {
        return $this->hasOne(Profiles::class, ['user_id'=>'user_id']);
    }

    public function  getAnketa() {
        return $this->hasOne(Anketa::class, ['user_id'=>'user_id']);
    }

    public function  getTest() {
        return $this->hasOne(ExamTest::class, ['id'=>'test_id']);
    }

    public static function find(): ExamAttemptQuery
    {
        return new  ExamAttemptQuery(static::class);
    }



}