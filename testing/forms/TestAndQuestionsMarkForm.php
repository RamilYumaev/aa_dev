<?php

namespace testing\forms;

use olympic\helpers\OlympicListHelper;
use testing\helpers\TestQuestionGroupHelper;
use testing\helpers\TestQuestionHelper;
use testing\models\Test;
use testing\models\TestAndQuestions;
use testing\models\TestQuestion;
use yii\base\Model;

class TestAndQuestionsMarkForm extends Model
{
    public $mark;
    public $id;
    public $andQuestions;

    public function __construct(TestAndQuestions $andQuestions, $config = [])
    {
        $this->andQuestions = $andQuestions;
        $this->mark = $andQuestions->mark;
        $this->id = $andQuestions->id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['mark', 'number', 'min' => 0, 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mark' => 'Балл',
        ];
    }
}