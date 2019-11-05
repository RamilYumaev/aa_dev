<?php


namespace dictionary\models;

use dictionary\forms\OlimpiadsTypeTemplatesCreateForm;
use dictionary\forms\OlimpiadsTypeTemplatesEditForm;
use dictionary\models\queries\DictClassQuery;
use dictionary\models\queries\OlimpiadsTypeTemplatesQuery;
use yii\db\ActiveRecord;

class OlimpiadsTypeTemplates extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olimpiads_type_templates';
    }

    public static function create(OlimpiadsTypeTemplatesCreateForm $form, $template_id, $special_type)
    {
        $olimpiadsTypeTemplates = new static();
        $olimpiadsTypeTemplates->number_of_tours = $form->number_of_tours;
        $olimpiadsTypeTemplates->form_of_passage = $form->form_of_passage;
        $olimpiadsTypeTemplates->edu_level_olimp = $form->edu_level_olimp;
        $olimpiadsTypeTemplates->template_id = $template_id;
        $olimpiadsTypeTemplates->special_type = $special_type;
        return $olimpiadsTypeTemplates;
    }

    public function edit(OlimpiadsTypeTemplatesEditForm $form, $template_id, $special_type)
    {
        $this->number_of_tours = $form->number_of_tours;
        $this->form_of_passage = $form->form_of_passage;
        $this->edu_level_olimp = $form->edu_level_olimp;
        $this->template_id = $template_id;
        $this->special_type = $special_type;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'number_of_tours' => 'Количество туров',
            'form_of_passage' => 'Форма проведения',
            'edu_level_olimp' => 'Уровень олимпиады',
            'template_id' => 'Шаблон',
            'special_type' => 'Специальный вид олимпиады (можно не заполнять)',

        ];
    }

    public static function labels(): array
    {
        $olimpiadsTypeTemplates = new static();
        return $olimpiadsTypeTemplates->attributeLabels();
    }

    public static function find(): OlimpiadsTypeTemplatesQuery
    {
        return new OlimpiadsTypeTemplatesQuery(static::class);
    }


}