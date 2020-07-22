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
    }

    public function getDateValue($property)
    {
        return DateFormatHelper::formatView($this->$property);
    }

    public function getDiscipline(){
        return $this->hasOne(DictDiscipline::class, ['id'=>'discipline_id']);
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
            'date_start_reserve' => "Резервная дата начала экзамена",
            'date_end_reserve' => "Резервная дата окончания экзамена",
            'time_start_reserve' => "Резервное время начала экзамена",
            'time_end_reserve' => "Резервное время окончания экзамена",
            'date_range' => "Дата экзамена (от и до)",
            'date_range_reserve' => "Резервная дата экзамена (от и до)",
            'time_range' => "Время экзамена (от и до)",
            'time_range_reserve' => "Резервное время экзамена (от и до)"
        ];
    }

    public static function find(): ExamQuery
    {
        return new  ExamQuery(static::class);
    }

}