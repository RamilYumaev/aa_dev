<?php


namespace tests\models;

use yii\db\ActiveRecord;

class TestQuestionGroup extends ActiveRecord
{
    public static function tableName()
    {
        return 'test_question_group';
    }

    public static function create($olimpic_id, $name)
    {
        $testQuestionGroup = new static();
        $testQuestionGroup->olimpic_id = $olimpic_id;
        $testQuestionGroup->name = $name;
        return $testQuestionGroup;
    }

    public function edit($olimpic_id, $name)
    {
        $this->olimpic_id = $olimpic_id;
        $this->name = $name;
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'olimpic_id' => 'Олимпиада',
            'name' => 'Имя',
        ];
    }

    public static function labels()
    {
        $testQuestionGroup = new static();
        return $testQuestionGroup->attributeLabels();
    }

}