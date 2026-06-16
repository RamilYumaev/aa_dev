<?php

namespace testing\forms;

use olympic\helpers\OlympicListHelper;
use testing\helpers\TestQuestionGroupHelper;
use testing\helpers\TestQuestionHelper;
use testing\models\Test;
use testing\models\TestAndQuestions;
use testing\models\TestQuestion;
use yii\base\Model;

class TestAndQuestionsTableMarkForm extends Model
{
    public $arrayMark;

    public function __construct($andQuestions, $config = [])
    {
        $this->arrayMark = [];
        if (!empty($andQuestions)) {
            foreach ($andQuestions as $quest) {
                // Предположим, что $quest — это массив или объект, который нужно преобразовать в другой объект.
                // Если нужен другой класс, укажите его явно.
                $this->arrayMark[] = new TestAndQuestionsMarkForm($quest);
            }
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