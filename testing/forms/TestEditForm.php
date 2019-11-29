<?php


namespace testing\forms;


use olympic\helpers\ClassAndOlympicHelper;
use olympic\helpers\OlympicHelper;
use testing\helpers\TestHelper;
use testing\models\Test;
use yii\base\Model;

class TestEditForm  extends Model
{
    public $olimpic_id,
        $status,
        $type_calculate_id,
        $calculate_value,
        $introduction,
        $final_review, $classesList;


    public function __construct(Test $test, $config = [])
    {
        $this->olimpic_id = $test->olimpic_id;
        $this->status = $test->status;
        $this->type_calculate_id = $test->type_calculate_id;
        $this->calculate_value = $test->calculate_value;
        $this->introduction = $test->introduction;
        $this->final_review = $test->final_review;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['olimpic_id'], 'required'],
            [['olimpic_id', 'status', 'type_calculate_id', 'calculate_value'], 'integer'],
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

    public function typeCalculateList(): array
    {
        return TestHelper::typeCalculateList();
    }


}