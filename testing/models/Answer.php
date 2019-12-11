<?php


namespace testing\models;

use yii\db\ActiveRecord;

class Answer extends ActiveRecord
{
    public static function tableName()
    {
        return 'answer';
    }

    public static function create($quest_id, $name, $isCorrect, $answerMatch)
    {
        $answer = new static();
        $answer->quest_id = $quest_id;
        $answer->name = $name;
        $answer->is_correct = $isCorrect;
        $answer->answer_match = $answerMatch;
        return $answer;
    }

    public function edit($name, $isCorrect, $answerMatch)
    {
        $this->name = $name;
        $this->is_correct = $isCorrect;
        $this->answer_match = $answerMatch;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quest_id' => 'Вопрос',
            'is_correct' => 'Правильный ответ',
            'name' => 'Наименование',
            'answer_match' => 'Сопоставление',
        ];
    }

    public static function labels()
    {
        $test = new static();
        return $test->attributeLabels();
    }


}