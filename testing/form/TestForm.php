<?php


namespace tests\forms;


use olympic\helpers\OlympicHelper;
use tests\models\Test;
use yii\base\Model;

class TestForm extends Model
{
    public $olimpic_id,
        $status,
        $type_calculate_id,
        $calculate_value,
        $introduction,
        $final_review,
        $questionGroupsList;

    public function __construct(Test $test = null, $config = [])
    {
        if ($test) {
            $this->olimpic_id = $test->olimpic_id;
            $this->status = $test->status;
            $this->type_calculate_id = $test->type_calculate_id;
            $this->calculate_value = $test->calculate_value;
            $this->introduction = $test->introduction;
            $this->final_review = $test->final_review;
            $this->questionGroupsList = $test->questionGroupsList;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['olimpic_id'], 'required'],
            [['olimpic_id', 'status', 'type_calculate_id', 'calculate_value'], 'integer'],
            [['introduction', 'final_review'], 'string'],
            [['classesList'], 'required'],
            [['classesList'], 'validateClassesList'],
            ['questionGroupsList', 'safe'],
        ];
    }

    public function validateClassesList($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        $query = TestClass::find()
            ->joinWith(['test'], false)
            ->andWhere([self::tableName() . '.olimpic_id' => $this->olimpic_id])
            ->andWhere(['in', 'class_id', $this->{$attribute}]);
        if ($this->id) {
            $query->andWhere(['<>', TestClass::tableName() . '.test_id', $this->id]);
        }

        if ($query->exists()) {
            $this->addError($attribute, 'Множество классов тестов в рамках одной олимпиады пересекаться не могут.');
        }
    }


    public function olimpicList(): array
    {
        return OlympicHelper::olimpicList();
    }


}