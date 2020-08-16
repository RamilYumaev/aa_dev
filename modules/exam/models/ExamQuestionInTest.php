<?php
namespace modules\exam\models;

use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%exam_question_in_test}}".
 *
 * @property integer $id
 * @property integer $question_id
 * @property integer $test_id
 * @property integer $question_group_id
 * @property integer $mark
 *
 **/


class ExamQuestionInTest extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%exam_question_in_test}}';
    }

    public static function create($question_group_id, $question_id, $test_id)
    {
        $testAndQuestions = new static();
        $testAndQuestions->question_group_id = $question_group_id;
        $testAndQuestions->test_id = $test_id;
        $testAndQuestions->question_id = $question_id;
        return $testAndQuestions;
    }

    public function addMark($mark)
    {
        $this->mark = $mark;
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

    public function getQuestion () {
        return $this->hasOne(ExamQuestion::class, ['id' => "question_id"]);
    }

    public function getQuestionGroup () {
        return $this->hasOne(ExamQuestionGroup::class, ['id' => "question_group_id"]);
    }

}