<?php


namespace tests\forms;


use olympic\helpers\OlympicHelper;
use tests\models\TestQuestionGroup;
use yii\base\Model;

class TestQuestionGroupForm extends Model
{
    public $olimpic_id, $name;

    public function __construct(TestQuestionGroup $questionGroup = null, $config = [])
    {
        if($questionGroup){
            $this->olimpic_id = $questionGroup->olimpic_id;
            $this->name = $questionGroup->name;
        }

        parent::__construct($config);
    }


    public function rules()
    {
        return TestQuestionGroup::labels();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'olimpic_id' => 'Олимпиада',
            'name' => 'Имя',
        ];
    }

    public function olimpicList(): array
    {
        return OlympicHelper::olimpicList();
    }
}