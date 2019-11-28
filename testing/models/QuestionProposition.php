<?php


namespace testing\models;

use yii\db\ActiveRecord;

class QuestionProposition extends ActiveRecord
{
    public static function tableName()
    {
        return 'question_proposition';
    }

    public static function create($quest_id, $name, $is_start, $type)
    {
        $answer = new static();
        $answer->quest_id = $quest_id;
        $answer->name = $name;
        $answer->is_start = $is_start;
        $answer->type = $type;
        return $answer;
    }

    public function edit($name, $isCorrect, $answerMatch)
    {
        $this->name = $name;
        $this->is_start = $isCorrect;
        $this->type = $answerMatch;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quest_id' => 'Вопрос',
            'is_start' => 'Вложенный ответ в начеле предложения ?',
            'name' => 'Предложение',
            'type' => 'Тип вложенного ответа',
        ];
    }

    public static function labels()
    {
        $test = new static();
        return $test->attributeLabels();
    }


}