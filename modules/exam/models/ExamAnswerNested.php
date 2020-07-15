<?php


namespace modules\exam\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exam_answer_nested}}".
 *
 * @property integer $id
 * @property integer $question_nested_id
 * @property integer $is_correct
 * @property string $name
 *
 **/

class ExamAnswerNested extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%exam_answer_nested}}';
    }

    public static function create($quest_prop_id, $name, $isCorrect)
    {
        $answer = new static();
        $answer->question_nested_id = $quest_prop_id;
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