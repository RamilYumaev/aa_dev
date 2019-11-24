<?php


namespace testing\forms;


use common\helpers\EduYearHelper;
use olympic\helpers\OlympicHelper;
use olympic\helpers\OlympicListHelper;
use testing\models\TestQuestionGroup;
use yii\base\Model;

class TestQuestionGroupEditForm extends Model
{
    public $olimpic_id, $name, $year, $_questionGroup;

    public function __construct(TestQuestionGroup $questionGroup, $config = [])
    {
        $this->olimpic_id = $questionGroup->olimpic_id;
        $this->name = $questionGroup->name;
        $this->year = $questionGroup->year;
        $this->_questionGroup = $questionGroup;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['olimpic_id', 'name', 'year'], 'required'],
            [['olimpic_id'], 'integer'],
            [['name', 'year'], 'unique', 'targetClass' => TestQuestionGroup::class,
                'filter' => ['<>', 'id', $this->_questionGroup->id],
                'message' => 'Такое название и учебный год уже есть',
                'targetAttribute' => ['name', 'year']],
            [['name', "year"], 'string', 'max' => 255],
        ];
    }


    public function attributeLabels()
    {
        return TestQuestionGroup::labels();
    }


    public function olympicList(): array
    {
        return OlympicListHelper::olympicListEduYear();
    }

    public function years(): array
    {
        return EduYearHelper::eduYearList();
    }
}