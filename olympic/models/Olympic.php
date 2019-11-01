<?php


namespace olympic\models;

use dictionary\models\queries\DictClassQuery;
use olympic\forms\OlympicCreateForm;
use olympic\forms\OlympicEditForm;
use olympic\models\queries\OlimpicQuery;

class Olympic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olimpic';
    }

    public static function create(OlympicCreateForm $form)
    {
        $olympic = new static();
        $olympic->name = $form->name;
        $olympic->status = $form->status; //????
        $olympic->chairman_id = null;
        $olympic->number_of_tours = null;
        $olympic->edu_level_olymp = null;
        $olympic->date_time_start_reg = null;
        $olympic->date_time_finish_reg = null;
        $olympic->genitive_name = '';
        $olympic->faculty_id = null;
        $olympic->time_of_distants_tour_type = null;
        $olympic->form_of_passage = null;
        $olympic->time_of_tour = null;
        $olympic->content = null;
        $olympic->required_documents = null;
        $olympic->showing_works_and_appeal = null;
        $olympic->time_of_distants_tour = null;
        $olympic->prefilling = 0;
        $olympic->only_mpgu_students = 0;
        $olympic->list_position = null;
        $olympic->auto_sum = null;
        $olympic->date_time_start_tour = null;
        $olympic->address = null;
        $olympic->requiment_to_work_of_distance_tour = null;
        $olympic->requiment_to_work = null;
        $olympic->criteria_for_evaluating_dt = null;
        $olympic->criteria_for_evaluating = null;
        $olympic->promotion_text = null;
        $olympic->link = null;
        $olympic->certificate_id = null;
        $olympic->event_type = null;
        return $olympic;
    }

    public function edit(OlympicEditForm $form)
    {
        $this->name = $form->name;
        $this->status = $form->status; //????
        $this->chairman_id = null;
        $this->number_of_tours = null;
        $this->edu_level_olymp = null;
        $this->date_time_start_reg = null;
        $this->date_time_finish_reg = null;
        $this->genitive_name = '';
        $this->faculty_id = null;
        $this->time_of_distants_tour_type = null;
        $this->form_of_passage = null;
        $this->time_of_tour = null;
        $this->content = null;
        $this->required_documents = null;
        $this->showing_works_and_appeal = null;
        $this->time_of_distants_tour = null;
        $this->prefilling = 0;
        $this->only_mpgu_students = 0;
        $this->list_position = null;
        $this->auto_sum = null;
        $this->date_time_start_tour = null;
        $this->address = null;
        $this->requiment_to_work_of_distance_tour = null;
        $this->requiment_to_work = null;
        $this->criteria_for_evaluating_dt = null;
        $this->criteria_for_evaluating = null;
        $this->promotion_text = null;
        $this->link = null;
        $this->certificate_id = null;
        $this->event_type = null;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Полное название мероприятия',
            'status' => 'Статус',
        ];
    }

    public static function labels(): array
    {
        $olympic = new static();
        return $olympic->attributeLabels();
    }

    public static function find(): OlimpicQuery
    {
        return new OlimpicQuery(static::class);
    }

}