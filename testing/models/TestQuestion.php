<?php


namespace tests\models;


use tests\forms\TestQuestionForm;
use yii\db\ActiveRecord;

class TestQuestion extends ActiveRecord
{

    public static function create(TestQuestionForm $form, $group_id)
    {
        $testQue = new static();
        $testQue->type_id = $form->type_id;
        $testQue->title = $form->title;
        $testQue->mark = $form->mark;
        $testQue->text = $form->text;
        $testQue->file_type_id = $form->file_type_id;
        $testQue->options = $form->options;
        $testQue->group_id = $group_id;
        return $testQue;
    }

    public function edit(TestQuestionForm $form, $group_id)
    {
        $this->type_id = $form->type_id;
        $this->title = $form->title;
        $this->mark = $form->mark;
        $this->text = $form->text;
        $this->file_type_id = $form->file_type_id;
        $this->options = $form->options;
        $this->group_id = $group_id;
    }


    public static function tableName()
    {
        return 'test_question';
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Группа вопросов',
            'type_id' => 'Тип вопроса',
            'title' => 'Заголовок',
            'text' => 'Вопрос',
            'mark' => 'Сумма первичных баллов',
            'options' => 'Варианты',
            'file_type_id' => 'Загружаемый тип файла',
            'type' => 'Тип вопроса',
            'optionsArray' => 'Варианты',
        ];
    }

    public static function labels()
    {
        $testQue = new static();
        $testQue->attributeLabels();
    }


}