<?php

namespace testing\forms;

use olympic\helpers\ClassAndOlympicHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use testing\helpers\TestHelper;
use testing\helpers\TestQuestionGroupHelper;
use testing\models\Test;
use yii\base\Model;

class TestCreateForm extends Model
{
    public $olimpic_id,
        $introduction,
        $final_review,
        $classesList;
    private $_olympicList;


    public function __construct(OlimpicList $olympicList, $config = [])
    {
        $this->_olympicList = $olympicList;
        $this->olimpic_id = $olympicList->id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['olimpic_id'], 'required'],
            [['olimpic_id'], 'integer'],
            [['introduction', 'final_review'], 'string'],
            [['classesList'], 'required'],
            [['classesList'], 'safe'],
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