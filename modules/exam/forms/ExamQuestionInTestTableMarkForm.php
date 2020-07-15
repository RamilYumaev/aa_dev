<?php

namespace modules\exam\forms;

use yii\base\Model;

class ExamQuestionInTestTableMarkForm extends Model
{
    public $arrayMark;
    public function __construct($questions, $config = [])
    {
        if ($questions) {
            $this->arrayMark =  array_map(function ($quest) {
            return new ExamQuestionInTestMarkForm($quest); }, $questions);
        } else {
            $this->arrayMark = [];
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['mark'], 'required'],
            [['mark'], 'integer'],
        ];
    }
}