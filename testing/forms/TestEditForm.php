<?php


namespace testing\forms;


use olympic\helpers\ClassAndOlympicHelper;
use olympic\helpers\OlympicHelper;
use testing\helpers\TestClassHelper;
use testing\helpers\TestHelper;
use testing\models\Test;
use yii\base\Model;

class TestEditForm  extends Model
{
    public $olimpic_id,
        $test,
        $introduction,
        $final_review,
        $random_order,
        $olympic_profile_id,
        $classesList;



    public function __construct(Test $test, $config = [])
    {
        $this->classesList= TestClassHelper::testClassList($test->id);
        $this->olimpic_id = $test->olimpic_id;
        $this->introduction = $test->introduction;
        $this->final_review = $test->final_review;
        $this->random_order = $test->random_order;
        $this->olympic_profile_id = $test->olympic_profile_id;
        $this->test = $test;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['olimpic_id'], 'required'],
            [['olimpic_id', 'random_order', 'olympic_profile_id'], 'integer'],
            [['introduction', 'final_review'], 'string'],
            [['classesList'], 'required'],
        ];
    }

    public function classFullNameList(): array
    {
        return ClassAndOlympicHelper::olympicClassLists($this->olimpic_id);
    }

    public function isFormOcnoZaochno(): bool
    {
        return $this->_olympicList->form_of_passage == OlympicHelper::OCHNO_ZAOCHNAYA_FORMA;
    }

    public function attributeLabels()
    {
        return Test::labels();
    }



}