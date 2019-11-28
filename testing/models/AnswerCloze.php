<?php


namespace testing\models;

use yii\db\ActiveRecord;

class AnswerCloze extends ActiveRecord
{
    public static function tableName()
    {
        return 'answer_cloze';
    }

    public static function create($quest_prop_id, $name, $isCorrect)
    {
        $answer = new static();
        $answer->quest_prop_id = $quest_prop_id;
        $answer->name = $name;
        $answer->is_correct = $isCorrect;
        return $answer;
    }

    public function edit($name, $isCorrect)
    {
        $this->name = $name;
        $this->is_correct = $isCorrect;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quest_prop_id' => 'Предложение вложенного ответв',
            'is_correct' => 'Правильный ответ',
            'name' => 'Наименование',
        ];
    }

    public static function labels()
    {
        $test = new static();
        return $test->attributeLabels();
    }

}