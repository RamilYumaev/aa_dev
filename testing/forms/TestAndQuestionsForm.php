<?php

namespace testing\forms;

use testing\helpers\TestQuestionHelper;
use yii\base\Model;

class TestAndQuestionsForm extends Model
{
    public $test_id, $test_group_id, $question_group_id, $questionList;

    public function __construct($test_id, $test_group_id, $question_group_id, $config = [])
    {
        $this->test_group_id = $test_group_id;
        $this->question_group_id = $question_group_id;
        $this->test_id = $test_id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['test_id','test_group_id', 'question_group_id', 'questionList'], 'required'],
            [['test_id', 'test_group_id'], 'integer'],
            [['questionList'], 'safe'],
        ];
    }

    public function questionList(): array
    {
        return TestQuestionHelper::questionList($this->question_group_id);
    }

    public function attributeLabels()
    {
        return ['questionList' => 'Вопросы, задания'];
    }

}