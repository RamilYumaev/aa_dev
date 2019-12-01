<?php

namespace testing\forms;

use olympic\helpers\OlympicListHelper;
use testing\helpers\TestQuestionGroupHelper;
use testing\helpers\TestQuestionHelper;
use testing\models\Test;
use yii\base\Model;

class TestAndQuestionsForm extends Model
{
    public $test_id, $test_group_id, $question_id;
    private $olympic, $isGroup;

    public function __construct(Test $test, $isGroup, $config = [])
    {
        $this->isGroup = $isGroup;
        $this->test_id = $test->id;
        $this->olympic = OlympicListHelper::olympicOne($test->olimpic_id);

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['test_id'], 'required'],
            [['test_group_id', 'question_id'], 'safe'],
            [['test_id', ], 'integer'],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforevalidate()) {
            if ($this->isGroup &&  empty($this->test_group_id)) {
                $this->addError('name', 'Необходимо заполнить «Группу вопросов».');
            }
            if (!$this->isGroup &&  empty($this->question_id)) {
                $this->addError('answer_match', 'Необходимо заполнить «Вопрос».');
            }
            return true;
        }
        return false;
    }
    

    public function questionList(): array
    {
        return TestQuestionHelper::questionOlympicList($this->olympic->olimpic_id);
    }

    public function questionGroupList(): array
    {
        return TestQuestionGroupHelper::testQuestionGroupOlympicInTestAndQuestionsList($this->olympic->olimpic_id);
    }


}