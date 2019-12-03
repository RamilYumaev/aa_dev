<?php


namespace testing\models;


use testing\models\queries\TestAttemptQuery;
use yii\db\ActiveRecord;

class TestAttempt extends ActiveRecord
{
    const GOLD = 1;
    const SILVER = 2;
    const BRONZE = 3;
    const MEMBER = 4;

    public static function tableName()
    {
        return 'test_attempt';
    }

    public static function create ($test_id) {
        $testAtt = new static();
        $testAtt->user_id = \Yii::$app->user->identity->getId();
        $testAtt->test_id = $test_id;
        $testAtt->start = date("Y-m-d H:i:s");
        $testAtt->end = null;
        return $testAtt;

    }

    public function edit() {
        $this->end = date("Y-m-d H:i:s");
    }

//    public function rules()
//    {
//        return [
//            [['user_id', 'test_id'], 'required'],
//            [['user_id', 'test_id', 'status_id'], 'integer'],
//            [['start', 'end'], 'date', 'format' => 'php:Y-m-d H:i:s'],
//            [['user_id', 'test_id'], 'unique', 'targetAttribute' => ['user_id', 'test_id']],
//            ['mark', 'number'],
//        ];
//    }
//
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'start' => 'Начало',
            'end' => 'Окончание',
            'test_id' => 'Тест',
            'mark' => 'Результат',
        ];
    }

    public static function find(): TestAttemptQuery
    {
        return new  TestAttemptQuery(static::class);
    }
}