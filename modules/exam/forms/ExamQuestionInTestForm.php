<?php

namespace modules\exam\forms;

use modules\exam\helpers\ExamQuestionGroupHelper;
use modules\exam\helpers\ExamQuestionHelper;
use modules\exam\models\ExamTest;
use yii\base\Model;

class ExamQuestionInTestForm extends Model
{
    public $test_id, $question_group_id, $question_id;
    private $isGroup;
    private $_test;

    public function __construct(ExamTest $test, $isGroup, $config = [])
    {
        $this->isGroup = $isGroup;
        $this->test_id = $test->id;
        $this->_test = $test;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['test_id'], 'required'],
            [['question_group_id', 'question_id'], 'safe'],
            [['test_id', ], 'integer'],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforevalidate()) {
            if ($this->isGroup &&  empty($this->question_group_id)) {
                $this->addError('question_group_id', 'Необходимо заполнить «Группу вопросов».');
            }
            if (!$this->isGroup &&  empty($this->question_id)) {
                $this->addError('question_id', 'Необходимо заполнить «Вопрос».');
            }
            return true;
        }
        return false;
    }
    

    public function questionList(): array
    {
        return ExamQuestionHelper::listQuestions($this->_test->exam->discipline_id);
    }

    public function questionGroupList(): array
    {
        return ExamQuestionGroupHelper::listQuestionGroupIds($this->_test->exam->discipline_id);
    }


}