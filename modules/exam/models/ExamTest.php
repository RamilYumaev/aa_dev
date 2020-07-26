<?php

namespace modules\exam\models;

use modules\exam\forms\ExamTestForm;
use testing\helpers\TestHelper;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%exam_test}}".
 *
 * @property integer $id
 * @property integer $exam_id
 * @property  string $name
 * @property  string $introduction
 * @property  string $final_review
 * @property integer $random_order
 * @property integer $status
 *
 **/

class ExamTest extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%exam_test}}";
    }

    public static function create(ExamTestForm $form)
    {
        $test = new static();
        $test->data($form);
        return $test;
    }

    public function data(ExamTestForm $form)
    {
        $this->random_order = $form->random_order;
        $this->introduction = $form->introduction;
        $this->exam_id = $form->exam_id;
        $this->name = $form->name;
        $this->final_review = $form->final_review;
    }

    public function getExam(){
        return $this->hasOne(Exam::class, ['id'=>'exam_id']);
    }

    public function getAttempt(){
        return $this->hasMany(ExamAttempt::class,['test_id'=> 'id']);
    }

    public function getCountAttempt($type)
    {
        return $this->getAttempt()->andWhere(['type'=> $type])->count();
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название теста',
            'exam_id' => 'Экзамен',
            'introduction' => 'Вступление',
            'final_review' => 'Итоговый отзыв',
            'status' => 'Открыть тест для участников',
            'random_order'=> 'Случайный порядок вопросов',
        ];
    }


    public function active() {
        return $this->status == TestHelper::ACTIVE;
    }

    public function draft() {
       return $this->status == TestHelper::DRAFT;
    }

}