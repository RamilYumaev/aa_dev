<?php

namespace tests\models;
use yii\db\ActiveRecord;

class TestGroup extends ActiveRecord
{
    public static function tableName()
    {
        return 'test_group';
    }

    public static function create ($test_id, $question_group_id)
    {
        $testGroup = new static();
        $testGroup->test_id = $test_id;
        $testGroup->question_group_id= $question_group_id;
        return $testGroup;
    }

    public function edit ($test_id, $question_group_id)
    {
        $this->test_id = $test_id;
        $this->question_group_id = $question_group_id;
    }

    public function attributeLabels()
    {
        return [
            'test_id' => 'Тест',
            'question_group_id' => 'Группа вопросов',
        ];
    }
}