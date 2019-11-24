<?php


namespace testing\forms;


use common\helpers\EduYearHelper;
use olympic\helpers\OlympicListHelper;
use testing\models\TestQuestionGroup;
use yii\base\Model;

class TestQuestionGroupCreateForm extends Model
{
    public $olimpic_id, $name, $year;

    public function __construct($olympic_id, $config = [])
    {
        $this->olimpic_id = $olympic_id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['olimpic_id', 'name', 'year'], 'required'],
            [['olimpic_id'], 'integer'],
            [['name', 'year'], 'unique', 'targetClass' => TestQuestionGroup::class,
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