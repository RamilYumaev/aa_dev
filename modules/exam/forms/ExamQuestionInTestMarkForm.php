<?php

namespace modules\exam\forms;

use modules\exam\models\ExamQuestionInTest;
use yii\base\Model;

class ExamQuestionInTestMarkForm extends Model
{
    public $mark;
    public $id;
    public $examQuestionInTest;

    public function __construct(ExamQuestionInTest $examQuestionInTest, $config = [])
    {
        $this->examQuestionInTest = $examQuestionInTest;
        $this->mark = $examQuestionInTest->mark;
        $this->id = $examQuestionInTest->id;
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