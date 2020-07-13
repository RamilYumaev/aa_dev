<?php

namespace modules\exam\models;

use testing\forms\TestCreateForm;
use testing\forms\TestEditForm;
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

    public static function create(TestCreateForm $form, $olimpic_id)
    {
        $test = new static();
        $test->olimpic_id = $olimpic_id;
        $test->status = TestHelper::DRAFT;
        $test->random_order = $form->random_order;
        $test->introduction = $form->introduction;
        $test->final_review = $form->final_review;
        return $test;
    }

    public function edit(TestEditForm $form, $olimpic_id)
    {
        $this->olimpic_id = $olimpic_id;
        $this->random_order = $form->random_order;
        $this->introduction = $form->introduction;
        $this->final_review = $form->final_review;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'olimpic_id' => 'Олимпиада',
            'introduction' => 'Вступление',
            'final_review' => 'Итоговый отзыв',
            'status' => 'Открыть тест для участников',
            'random_order'=> 'Случайный порядок вопросов',
            'type_calculate_id' => 'Критерий расчета прохода в следующий тур',
            'calculate_value' => 'Значение для расчета',
        ];
    }

    public static function labels()
    {
        $test = new static();
        return $test->attributeLabels();
    }

    public function active() {
        return $this->status == TestHelper::ACTIVE;
    }

    public function draft() {
       return $this->status == TestHelper::DRAFT;
    }

}