<?php


namespace olympic\models;

use olympic\forms\OlympicCreateForm;
use olympic\forms\OlympicEditForm;

class Olympic extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olimpic';
    }

    public static function create(OlympicCreateForm $form, $chairman_id, $faculty_id)
    {
        $olympic = new static();
        $olympic->name = $form->name;
        $olympic->chairman_id = $chairman_id;
        $olympic->number_of_tours = $form->number_of_tours;
        $olympic->edu_level_olymp = $form->edu_level_olymp;
        $olympic->date_time_start_reg = $form->date_time_start_reg;
        $olympic->date_time_finish_reg = $form->date_time_finish_reg;
        $olympic->genitive_name = $form->genitive_name;
        $olympic->faculty_id = $faculty_id;
        $olympic->time_of_distants_tour_type = $form->time_of_distants_tour_type;
        $olympic->form_of_passage = $form->form_of_passage;
        $olympic->time_of_tour = $form->time_of_tour;
        $olympic->content = $form->content;
        $olympic->required_documents = $form->required_documents;
        $olympic->showing_works_and_appeal = $form->showing_works_and_appeal;
        $olympic->time_of_distants_tour = $form->time_of_distants_tour;
        $olympic->prefilling = $form->prefilling;
        $olympic->only_mpgu_students = $form->only_mpgu_students;
        $olympic->list_position = $form->list_position;
        $olympic->current_status = 0; //????
        $olympic->auto_sum = $form->auto_sum;
        $olympic->date_time_start_tour = $form->date_time_start_tour;
        $olympic->address = $form->address;
        $olympic->requiment_to_work_of_distance_tour = $form->requiment_to_work_of_distance_tour;
        $olympic->requiment_to_work = $form->requiment_to_work;
        $olympic->criteria_for_evaluating_dt = $form->criteria_for_evaluating_dt;
        $olympic->criteria_for_evaluating = $form->criteria_for_evaluating;
        $olympic->promotion_text = $form->promotion_text;
        $olympic->link = $form->link;
        $olympic->certificate_id = $form->certificate_id;
        $olympic->event_type = $form->event_type;
        return $olympic;
    }

    public function edit(OlympicEditForm $form, $chairman_id, $faculty_id)
    {
        $this->name = $form->name;
        $this->chairman_id = $chairman_id;
        $this->number_of_tours = $form->number_of_tours;
        $this->edu_level_olymp = $form->edu_level_olymp;
        $this->date_time_start_reg = $form->date_time_start_reg;
        $this->date_time_finish_reg = $form->date_time_finish_reg;
        $this->genitive_name = $form->genitive_name;
        $this->faculty_id = $faculty_id;
        $this->time_of_distants_tour_type = $form->time_of_distants_tour_type;
        $this->form_of_passage = $form->form_of_passage;
        $this->time_of_tour = $form->time_of_tour;
        $this->content = $form->content;
        $this->required_documents = $form->required_documents;
        $this->showing_works_and_appeal = $form->showing_works_and_appeal;
        $this->time_of_distants_tour = $form->time_of_distants_tour;
        $this->prefilling = $form->prefilling;
        $this->only_mpgu_students = $form->only_mpgu_students;
        $this->list_position = $form->list_position;
        $this->current_status = $form->current_status;
        $this->auto_sum = $form->auto_sum;
        $this->date_time_start_tour = $form->date_time_start_tour;
        $this->address = $form->address;
        $this->requiment_to_work_of_distance_tour = $form->requiment_to_work_of_distance_tour;
        $this->requiment_to_work = $form->requiment_to_work;
        $this->criteria_for_evaluating_dt = $form->criteria_for_evaluating_dt;
        $this->criteria_for_evaluating = $form->criteria_for_evaluating;
        $this->promotion_text = $form->promotion_text;
        $this->link = $form->link;
        $this->certificate_id = $form->certificate_id;
        $this->event_type = $form->event_type;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Полное название мероприятия',
            'chairman_id' => 'Председатель оргкомитета',
            'number_of_tours' => 'Количество туров',
            'form_of_passage' => 'Форма проведения',
            'edu_level_olymp' => 'Уровень олимпиады',
            'date_time_start_reg' => 'Дата и время начала регистрации',
            'date_time_finish_reg' => 'Дата и время завершения регистрации',
            'time_of_distants_tour' => 'Продолжительность выполнения заданий заочного (дистанционного) тура в минутах',
            'date_time_start_tour' => 'Дата и время проведения очного тура',
            'address' => 'Адрес проведения очного тура',
            'time_of_tour' => 'Продолжительность выполнения заданий очного тура в минутах',
            'requiment_to_work_of_distance_tour' => 'Требование к выполнению работ заочного (дистанционного) тура',
            'requiment_to_work' => 'Требование к выполнению работ очного тура',
            'criteria_for_evaluating_dt' => 'Критерии оценивания работ заочного (дистанционного) тура',
            'criteria_for_evaluating' => 'Критерии оценивания работ очного тура',
            'showing_works_and_appeal' => 'Показ работ и апелляция',
            'competitiveGroupsList' => 'Выберите конкурсные группы',
            'classesList' => 'Выберите классы и курсы',
            'genitive_name' => 'Название олимпиады/конкурса в родительном падеже',
            'time_of_distants_tour_type' => 'Тип установки времени для прохождения теста дистанционного тура',
            'prefilling' => 'Тип заполнения мероприятия',
            'faculty_id' => 'Учредитель мероприятия',
            'only_mpgu_students' => 'Только для студентов МПГУ',
            'promotion_text' => 'Рекламный текст, который будет завлекать участников',
            'link' => 'Ссылка на страницу регистрации (для олимпиад, которые не проводятся на нашем сайте)',
            'list_position' => 'Позиция на странице олимпиад',
            'content' => 'Аннотация на главную страницу олимпиады',
            'required_documents' => 'Необходимые документы на очный тур',
        ];
    }

    public static function labels(): array
    {
        $olympic = new static();
        return $olympic->attributeLabels();
    }

    public static function minutePicker()
    {

        $result = [];
        for ($i = 0; $i <= 180; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }

}