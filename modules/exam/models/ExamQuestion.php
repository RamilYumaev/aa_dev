<?php


namespace modules\exam\models;

use testing\forms\question\TestQuestionForm;
use testing\forms\question\TestQuestionEditForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exam_question}}".
 *
 * @property integer $id
 * @property integer $question_group_id
 * @property integer $exam_id
 * @property integer $type_id
 * @property string $title
 * @property string $text
 * @property integer $file_type_id
 *
 **/

class ExamQuestion extends ActiveRecord
{

    public static function create(TestQuestionForm $form, $group_id, $file_type_id, $options, $olympic_id)
    {
        $testQue = new static();
        $testQue->type_id = $form->type_id;
        $testQue->title = $form->title;
        $testQue->mark = null;
        $testQue->text = $form->text;
        $testQue->file_type_id = $file_type_id ?? null;
        $testQue->options = $options;
        $testQue->group_id = $group_id;
        $testQue->olympic_id = $olympic_id;
        return $testQue;
    }

    public function edit(TestQuestionEditForm $form,  $group_id, $file_type_id)
    {
        $this->title = $form->title;
        $this->text = $form->text;
        $this->file_type_id = $file_type_id ?? null;
        $this->group_id = $group_id;
    }


    public static function tableName()
    {
        return '{{%exam_question}}';
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_group_id' => 'Группа вопросов',
            'type_id' => 'Тип вопроса',
            'title' => 'Заголовок',
            'text' => 'Вопрос',
            'file_type_id' => 'Загружаемый тип файла',
            'type' => 'Тип вопроса',
        ];
    }

    public function getAnswer () {
        return $this->hasMany(Answer::class, ['quest_id' => "id"]);
    }

    public function getAnswerCorrect () {
        return $this->getAnswer()->andWhere( ['is_correct' => true]);
    }

    public function getAnswerUser ($ids) {
        return $this->getAnswer()->andWhere(['id' =>$ids]);
    }


    public static function labels()
    {
        $testQue = new static();
        return $testQue->attributeLabels();
    }




}