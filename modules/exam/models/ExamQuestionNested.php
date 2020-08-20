<?php


namespace modules\exam\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exam_question_nested}}".
 *
 * @property integer $id
 * @property integer $question_id
 * @property integer $is_start
 * @property string $name
 * @property integer $type
 *
 **/

class ExamQuestionNested extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%exam_question_nested}}';
    }

    public static function create($quest_id, $name, $is_start, $type)
    {
        $answer = new static();
        $answer->question_id = $quest_id;
        $answer->name = $name;
        $answer->is_start = $is_start;
        $answer->type = $type;
        return $answer;
    }

    public function edit($name, $is_start, $type)
    {
        $this->name = $name;
        $this->is_start = $is_start;
        $this->type = $type;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quest_id' => 'Вопрос',
            'is_start' => 'Вложенный ответ в начале предложения ?',
            'name' => 'Предложение',
            'type' => 'Тип вложенного ответа',
        ];
    }

    public static function labels()
    {
        $test = new static();
        return $test->attributeLabels();
    }

    public function getAnswer(){
        return $this->hasMany(ExamAnswerNested::class, ['question_nested_id' => 'id']);
    }

    public function getNestedAnswerCorrect() {
        return $this->getAnswer()->select(['name','question_nested_id'])->andWhere(['is_correct'=> true])->indexBy('question_nested_id')->column();
    }



}