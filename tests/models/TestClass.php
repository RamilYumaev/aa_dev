<?php


namespace tests\models;


use yii\db\ActiveRecord;

class TestClass extends ActiveRecord
{
    public static function tableName()
    {
        return 'test_class';
    }

    public static function create ($test_id, $class_id)
    {
        $testClass = new static();
        $testClass->test_id = $test_id;
        $testClass->class_id = $class_id;
        return $testClass;
    }

    public function edit ($test_id, $class_id)
    {
        $this->test_id = $test_id;
        $this->class_id = $class_id;
    }

    public function attributeLabels()
    {
        return [
            'test_id' => 'Тест',
            'class_id' => 'Класс',
        ];
    }
}