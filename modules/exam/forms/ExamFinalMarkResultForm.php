<?php

namespace modules\exam\forms;
use modules\exam\models\ExamQuestionInTest;
use modules\exam\models\ExamResult;
use yii\base\Model;

class ExamFinalMarkResultForm extends Model
{
    public $mark;
    private $t_q;
    public $note;

    public function __construct(ExamResult $testResult, $config = [])
    {
        $this->mark = $testResult->mark;
        $this->note = $testResult->note;
        $this->t_q= ExamQuestionInTest::findOne($testResult->tq_id)->mark;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['mark', 'required'],
            ['note', 'string'],
            ['mark', 'number', 'min' => 0, 'max' => $this->t_q],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mark' => 'Оценка',
            'note' => 'Комментарий к ответу',
        ];
    }
}