<?php

namespace testing\forms;
use olympic\models\PersonalPresenceAttempt;
use testing\models\TestAndQuestions;
use testing\models\TestResult;
use yii\base\Model;

class AddFinalMarkResultForm extends Model
{
    public $mark;
    private $t_q;

    public function __construct(TestResult $testResult, $config = [])
    {
        $this->mark = $testResult->mark;
        $this->t_q= TestAndQuestions::findOne($testResult->tq_id)->mark;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['mark', 'required'],
            ['mark', 'number', 'min' => 0, 'max' => $this->t_q],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mark' => 'Оценка',
        ];
    }
}