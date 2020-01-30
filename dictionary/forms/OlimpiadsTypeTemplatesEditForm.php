<?php


namespace dictionary\forms;


use common\helpers\EduYearHelper;
use dictionary\helpers\DictSpecialTypeOlimpicHelper;
use dictionary\helpers\TemplatesHelper;
use olympic\helpers\OlympicHelper;
use dictionary\models\OlimpiadsTypeTemplates;
use dictionary\models\Templates;
use yii\base\Model;

class OlimpiadsTypeTemplatesEditForm extends Model
{
    public $number_of_tours, $form_of_passage, $edu_level_olimp, $template_id, $year, $special_type,
        $_olimpiadsTypeTemplates, $range;

    public function __construct(OlimpiadsTypeTemplates $olimpiadsTypeTemplates, $config = [])
    {
        $this->number_of_tours = $olimpiadsTypeTemplates->number_of_tours;
        $this->form_of_passage = $olimpiadsTypeTemplates->form_of_passage;
        $this->edu_level_olimp = $olimpiadsTypeTemplates->edu_level_olimp;
        $this->template_id = $olimpiadsTypeTemplates->template_id;
        $this->special_type = $olimpiadsTypeTemplates->special_type;
        $this->year = $olimpiadsTypeTemplates->year;
        $this->range = $olimpiadsTypeTemplates->range;
        $this->_olimpiadsTypeTemplates = $olimpiadsTypeTemplates;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id', 'year', 'range'], 'required'],
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id', 'special_type', 'range'], 'integer'],
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id'], 'unique', 'targetClass' => OlimpiadsTypeTemplates::class,
                'filter' => ['<>', 'id', $this->_olimpiadsTypeTemplates->id], 'targetAttribute' => ['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'range', 'template_id', 'year']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Templates::class, 'targetAttribute' => ['template_id' => 'id']],
            ['number_of_tours', 'in', 'range' => OlympicHelper::numberOfToursValid(), 'allowArray' => true],
            ['form_of_passage', 'in', 'range' => OlympicHelper::formOfPassageValid(), 'allowArray' => true],
            ['edu_level_olimp', 'in', 'range' => OlympicHelper::levelOlimpValid(), 'allowArray' => true],
            ['range', 'in', 'range' =>self::range(), 'allowArray' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return OlimpiadsTypeTemplates::labels();
    }

    public function templatesList(): array
    {
        return TemplatesHelper::templatesList();
    }

    public function specialTypeOlimpicList(): array
    {
        return DictSpecialTypeOlimpicHelper::specialTypeOlimpicList();
    }

    public function numberOfTours()
    {
        return OlympicHelper::numberOfTours();
    }

    public function levelOlimp()
    {
        return OlympicHelper::levelOlimp();
    }

    public function formOfPassage()
    {
        return OlympicHelper::formOfPassage();
    }

    public function years(): array
    {
        return EduYearHelper::eduYearList();
    }

    public function range(): array
    {
        return [0,1,2,3,4,5,6,7,8,9,10];
    }

}