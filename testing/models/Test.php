<?php

namespace testing\models;

use tests\forms\TestForm;
use yii\db\ActiveRecord;

class Test extends ActiveRecord
{
    public static function tableName()
    {
        return 'test';
    }

    public static function create(TestForm $form, $olimpic_id,
                                  $questionGroupsList)
    {
        $test = new static();
        $test->olimpic_id = $olimpic_id;
        $test->status = $form->status;
        $test->type_calculate_id = $form->type_calculate_id;
        $test->calculate_value = $form->calculate_value;
        $test->introduction = $form->introduction;
        $test->final_review = $form->final_review;
        $test->questionGroupsList = $questionGroupsList;
        return $test;
    }

    public function edit(TestForm $form, $olimpic_id,
                         $questionGroupsList)
    {
        $this->olimpic_id = $olimpic_id;
        $this->status = $form->status;
        $this->type_calculate_id = $form->type_calculate_id;
        $this->calculate_value = $form->calculate_value;
        $this->introduction = $form->introduction;
        $this->final_review = $form->final_review;
        $this->questionGroupsList = $questionGroupsList;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'olimpic_id' => 'Олимпиада',
            'introduction' => 'Вступление',
            'final_review' => 'Итоговый отзыв',
            'status' => 'Открыть тест для участников',
            'classesList' => 'Классы',
            'questionGroupsList' => 'Группы вопросов',
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