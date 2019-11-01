<?php


namespace dictionary\forms;


use dictionary\helpers\DictSpecialTypeOlimpicHelper;
use dictionary\helpers\TemplatesHelper;
use olympic\helpers\OlympicHelper;
use dictionary\models\OlimpiadsTypeTemplates;
use dictionary\models\Templates;
use yii\base\Model;

class OlimpiadsTypeTemplatesCreateForm extends Model
{
    public $number_of_tours, $form_of_passage, $edu_level_olimp, $template_id, $special_type;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id'], 'required'],
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id', 'special_type'], 'integer'],
            [['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id'], 'unique', 'targetClass' => OlimpiadsTypeTemplates::class, 'targetAttribute' => ['number_of_tours', 'form_of_passage', 'edu_level_olimp', 'template_id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Templates::class, 'targetAttribute' => ['template_id' => 'id']],
            ['number_of_tours', 'in', 'range' => OlympicHelper::numberOfToursValid(), 'allowArray' => true],
            ['form_of_passage', 'in', 'range' => OlympicHelper::formOfPassageValid(), 'allowArray' => true],
            ['edu_level_olimp', 'in', 'range' => OlympicHelper::levelOlimpValid(), 'allowArray' => true],
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

}