<?php

namespace modules\exam\forms;

use modules\dictionary\models\JobEntrant;
use modules\exam\models\Exam;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ExamForm extends Model
{
    public $user_id, $date_range, $date_range_reserve, $time_exam,
                     $time_range_reserve, $time_range, $discipline_id;

    private $_exam;
    public $jobEntrant;

    public function __construct(JobEntrant $jobEntrant =null, Exam $exam = null, $config = [])
    {
        if($exam){
            $this->setAttributes($exam->getAttributes(), false);
            $this->date_range = $exam->getDateValue("date_start")." - ".$exam->getDateValue("date_end");
            $this->time_range = $exam->time_start." - ".$exam->time_end;
            $this->date_range_reserve = $exam->date_start_reserve ? $exam->getDateValue("date_start_reserve")." - ".$exam->getDateValue("date_end_reserve"): null;
            $this->time_range_reserve = $exam->time_start_reserve ? $exam->time_start_reserve." - ".$exam->time_end_reserve : null;
            $this->_exam = $exam;
        }

        $this->jobEntrant = $jobEntrant;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['date_range', 'time_range', 'time_exam', 'discipline_id'], 'required'],
            [['user_id','time_exam', 'discipline_id'], 'integer'],
            [['date_range', 'time_range', 'date_range_reserve','time_range_reserve'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['discipline_id'], 'unique', 'targetClass' => Exam::class, 'message'=>'Вы уже добавили'];
        if ($this->_exam) {
               return ArrayHelper::merge($arrayUnique,['filter' => ['<>', 'id', $this->_exam->id]]);
        }
        return $arrayUnique;
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new Exam())->attributeLabels();
    }




}