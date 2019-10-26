<?php


namespace olympic\forms;


use dictionary\helpers\DictSpecialTypeOlimpicHelper;
use dictionary\helpers\TemplatesHelper;
use olympic\models\OlimpiadsTypeTemplates;
use dictionary\models\Templates;
use yii\base\Model;

class OlimpiadsTypeTemplatesForm extends Model
{
    public $number_of_tours, $form_of_passage, $edu_level_olimp, $template_id, $special_type;

    public function __construct(OlimpiadsTypeTemplates $olimpiadsTypeTemplates = null,$config = [])
    {
        if ($olimpiadsTypeTemplates){
            $this->number_of_tours = $olimpiadsTypeTemplates->number_of_tours;
            $this->form_of_passage = $olimpiadsTypeTemplates->form_of_passage;
            $this->edu_level_olimp = $olimpiadsTypeTemplates->edu_level_olimp;
            $this->template_id = $olimpiadsTypeTemplates->template_id;
            $this->special_type = $olimpiadsTypeTemplates->special_type;
        }
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

}