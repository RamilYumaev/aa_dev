<?php
namespace testing\models;

use yii\db\ActiveRecord;

class TestAndQuestions extends ActiveRecord
{
    public static function tableName()
    {
        return 'test_and_questions';
    }

    public static function create($test_group_id, $question_id, $test_id)
    {
        $testAndQuestions = new static();
        $testAndQuestions->test_group_id = $test_group_id;
        $testAndQuestions->test_id = $test_id;
        $testAndQuestions->question_id = $question_id;
        return $testAndQuestions;
    }

    public function edit($test_group_id, $question_id, $test_id)
    {
        $this->test_group_id = $test_group_id;
        $this->question_id = $question_id;
        $this->test_id = $test_id;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_group_id' => 'Группа воппрса данного теста',
            'question_id' => 'Вопросы',
        ];
    }

    public static function labels()
    {
        $testAndQuestions = new static();
        return $testAndQuestions->attributeLabels();
    }

}