<?php


namespace testing\models;

use testing\forms\TestQuestionGroupCreateForm;
use testing\forms\TestQuestionGroupEditForm;
use yii\db\ActiveRecord;

class TestQuestionGroup extends ActiveRecord
{
    public static function tableName()
    {
        return 'test_question_group';
    }

    public static function create($olimpic_id, TestQuestionGroupCreateForm $form)
    {
        $testQuestionGroup = new static();
        $testQuestionGroup->olimpic_id = $olimpic_id;
        $testQuestionGroup->name = $form->name;
        $testQuestionGroup->year = $form->year;
        return $testQuestionGroup;
    }

    public function edit($olimpic_id, TestQuestionGroupEditForm $form)
    {
        $this->olimpic_id = $olimpic_id;
        $this->name = $form->name;
        $this->year = $form->year;
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'olimpic_id' => 'Олимпиада',
            'name' => 'Имя',
            'year' => 'Учебный год'
        ];
    }

    public static function labels()
    {
        $testQuestionGroup = new static();
        return $testQuestionGroup->attributeLabels();
    }

}