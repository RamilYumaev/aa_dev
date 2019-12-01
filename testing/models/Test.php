<?php

namespace testing\models;

use testing\forms\TestCreateForm;
use testing\forms\TestEditForm;
use testing\forms\TestForm;
use testing\helpers\TestHelper;
use yii\db\ActiveRecord;

class Test extends ActiveRecord
{
    public static function tableName()
    {
        return 'test';
    }

    public static function create(TestCreateForm $form, $olimpic_id)
    {
        $test = new static();
        $test->olimpic_id = $olimpic_id;
        $test->status = TestHelper::DRAFT;
        $test->introduction = $form->introduction;
        $test->final_review = $form->final_review;
        return $test;
    }

    public function edit(TestEditForm $form, $olimpic_id)
    {
        $this->olimpic_id = $olimpic_id;
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
            'type_calculate_id' => 'Критерий расчета прохода в следующий тур',
            'calculate_value' => 'Значение для расчета',
        ];
    }

    public static function labels()
    {
        $test = new static();
        return $test->attributeLabels();
    }

}