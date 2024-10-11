<?php

namespace testing\models;

use olympic\models\OlympicSpecialityProfile;
use testing\forms\TestCreateForm;
use testing\forms\TestEditForm;
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
        $test->random_order = $form->random_order;
        $test->introduction = $form->introduction;
        $test->final_review = $form->final_review;
        $test->olympic_profile_id = $form->olympic_profile_id ?? null;
        return $test;
    }

    public function edit(TestEditForm $form, $olimpic_id)
    {
        $this->olimpic_id = $olimpic_id;
        $this->random_order = $form->random_order;
        $this->introduction = $form->introduction;
        $this->final_review = $form->final_review;
        $this->olympic_profile_id = $form->olympic_profile_id ?? null;
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
            'olympic_profile_id' => 'Профиль олимпиады'
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

    public function getAttempt($userId)
    {
        return $this->hasOne(TestAttempt::class, ['test_id'=> 'id'])->andWhere(['user_id'=> $userId])->one();
    }

    public function getOlympicSpecialityProfile()
    {
        return $this->hasOne(OlympicSpecialityProfile::class, ['id'=> 'olympic_profile_id']);
    }
}
