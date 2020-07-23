<?php


namespace modules\exam\models;


use dictionary\models\DictDiscipline;
use modules\entrant\helpers\DateFormatHelper;
use modules\exam\forms\ExamForm;
use modules\exam\models\queries\ExamAttemptQuery;
use modules\exam\models\queries\ExamQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exam}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $discipline_id
 * @property string $date_start
 * @property string $date_end
 * @property string $date_start_reserve
 * @property string $date_end_reserve
 * @property integer $time_exam
 * @property string $time_start
 * @property string $time_end
 * @property string $time_start_reserve
 * @property string $time_end_reserve
 *
 **/


class Exam extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%exam}}';
    }

    public static function create(ExamForm $form)
    {
        $exam = new static();
        $exam->data($form);
        return $exam;
    }

    public function data(ExamForm $form) {
        $dates = explode(" - ", $form->date_range);
        $times = explode(" - ", $form->time_range);
        $this->user_id = $form->user_id;
        $this->discipline_id = $form->discipline_id;
        $this->time_exam = $form->time_exam;
        $this->time_start = $times[0];
        $this->time_end = $times[1];
        $this->date_start =  DateFormatHelper::formatRecord($dates[0]);
        $this->date_end =  DateFormatHelper::formatRecord($dates[1]);
        if($form->date_range_reserve && $form->time_range_reserve) {
            $dates = explode(" - ", $form->date_range_reserve);
            $times = explode(" - ", $form->time_range_reserve);
            $this->time_start_reserve = $times[0];
            $this->time_end_reserve = $times[1];
            $this->date_start_reserve =  DateFormatHelper::formatRecord($dates[0]);
            $this->date_end_reserve =  DateFormatHelper::formatRecord($dates[1]);
        }else {
            $this->time_start_reserve = null;
            $this->time_end_reserve = null;
            $this->date_start_reserve = null;
            $this->date_end_reserve =  null;
        }
    }

    public function getDateValue($property)
    {
        return DateFormatHelper::formatView($this->$property);
    }

    public function getDiscipline(){
        return $this->hasOne(DictDiscipline::class, ['id'=>'discipline_id']);
    }

    public function getExamStatement(){
        return $this->hasMany(ExamStatement::class, ['exam_id'=>'id']);
    }

    public function getExamTest(){
        return $this->hasMany(ExamTest::class, ['exam_id'=>'id']);
    }

    public function examStatementUser($userId){
        return $this->getExamStatement()->andWhere(['entrant_user_id'=> $userId])->one();
    }

    public function attributeLabels()
    {
        return [
            'user_id' => "Создатель",
            'discipline_id'=> 'Дисциплина',
            'date_start' => "Дата начала экзамена",
            'date_end' => "Дата окончания экзамена",
            'time_start' => "Время начала экзамена",
            'time_end' => "Время окончания экзамена",
            'time_exam' => "Продолжительность экзамена в минутах",
            'date_start_reserve' => "Дата начала экзамена для заочной формы",
            'date_end_reserve' => "Дата окончания экзамена для заочной формы",
            'time_start_reserve' => "Время начала экзамена для заочной формы",
            'time_end_reserve' => "Время окончания экзамена для заочной формы",
            'date_range' => "Дата экзамена (от и до)",
            'date_range_reserve' => "Дата экзамена (от и до) для заочной формы",
            'time_range' => "Время экзамена (от и до)",
            'time_range_reserve' => "Время экзамена (от и до) для заочной формы"
        ];
    }

    public function getDateExam()
    {
        return  $this->date_start == $this->date_end ? $this->getDateValue('date_start') : $this->getDateValue('date_start').' - '.$this->getDateValue('date_end');
    }

    public function getDateExamReserve()
    {
        return  $this->date_start_reserve == $this->date_end_reserve ? $this->getDateValue('date_start_reserve') : $this->getDateValue('date_start_reserve').' - '.$this->getDateValue('date_end_reserve');
    }

    public function getTimeExam()
    {
        return  $this->time_start.' - '.$this->time_end;
    }

    public function getTimeExamReserve()
    {
        return  $this->time_start_reserve.' - '.$this->time_end_reserve;
    }


    public static function find(): ExamQuery
    {
        return new  ExamQuery(static::class);
    }

}