<?php


namespace olympic\models;

use common\helpers\DateTimeCpuHelper;
use dictionary\helpers\DictChairmansHelper;
use dictionary\models\OlimpiadsTypeTemplates;
use olympic\forms\OlimpicListCopyForm;
use olympic\forms\OlimpicListCreateForm;
use olympic\forms\OlimpicListEditForm;
use dictionary\helpers\DictFacultyHelper;
use olympic\helpers\ClassAndOlympicHelper;
use olympic\helpers\OlimpicCgHelper;
use olympic\helpers\OlympicHelper;
use yii\helpers\Html;


class OlimpicList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    private $_olmpicTypeTemplate;

    public static function tableName()
    {
        return 'olimpic_list';
    }

    public function __construct($config = [])
    {
        $this->_olmpicTypeTemplate = new OlimpiadsTypeTemplates();
        parent::__construct($config);
    }

    public static function create(OlimpicListCreateForm $form, $chairman_id, $faculty_id, $olimpic_id)
    {
        $olympic = new static();
        $dates = explode(" - ", $form->date_range);
        $olympic->name = $form->name;
        $olympic->chairman_id = $chairman_id;
        $olympic->number_of_tours = $form->number_of_tours;
        $olympic->edu_level_olymp = $form->edu_level_olymp;
        $olympic->date_time_start_reg = $dates[0];
        $olympic->date_time_finish_reg =  $dates[1];
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
        $olympic->current_status = 0;
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
        $olympic->percent_to_calculate = $form->percent_to_calculate;
        $olympic->event_type = $form->event_type;
        $olympic->olimpic_id = $olimpic_id;
        $olympic->year = $form->year;
        return $olympic;
    }

    public static function copy(OlimpicListCopyForm $form, $chairman_id, $faculty_id, $olimpic_id)
    {
        $olympic = new static();
        $dates = explode(" - ", $form->date_range);
        $olympic->name = $form->name;
        $olympic->chairman_id = $chairman_id;
        $olympic->number_of_tours = $form->number_of_tours;
        $olympic->edu_level_olymp = $form->edu_level_olymp;
        $olympic->date_time_start_reg = $dates[0];
        $olympic->date_time_finish_reg =  $dates[1];
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
        $olympic->current_status = 0;
        $olympic->auto_sum = $form->auto_sum;
        $olympic->date_time_start_tour = $form->date_time_start_tour;
        $olympic->address = $form->address;
        $olympic->requiment_to_work_of_distance_tour = $form->requiment_to_work_of_distance_tour;
        $olympic->requiment_to_work = $form->requiment_to_work;
        $olympic->criteria_for_evaluating_dt = $form->criteria_for_evaluating_dt;
        $olympic->criteria_for_evaluating = $form->criteria_for_evaluating;
        $olympic->promotion_text = $form->promotion_text;
        $olympic->link = $form->link;
        $olympic->percent_to_calculate = $form->percent_to_calculate;
        $olympic->certificate_id = $form->certificate_id;
        $olympic->event_type = $form->event_type;
        $olympic->olimpic_id = $olimpic_id;
        $olympic->year = $form->year;
        return $olympic;
    }

    public function edit(OlimpicListEditForm $form, $chairman_id, $faculty_id, $olimpic_id)
    {
        $this->name = $form->name;
        $dates = explode(" - ", $form->date_range);
        $this->chairman_id = $chairman_id;
        $this->number_of_tours = $form->number_of_tours;
        $this->edu_level_olymp = $form->edu_level_olymp;
        $this->date_time_start_reg = $dates[0];
        $this->date_time_finish_reg =  $dates[1];
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
        $this->auto_sum = $form->auto_sum;
        $this->date_time_start_tour = $form->date_time_start_tour;
        $this->address = $form->address;
        $this->requiment_to_work_of_distance_tour = $form->requiment_to_work_of_distance_tour;
        $this->requiment_to_work = $form->requiment_to_work;
        $this->criteria_for_evaluating_dt = $form->criteria_for_evaluating_dt;
        $this->criteria_for_evaluating = $form->criteria_for_evaluating;
        $this->promotion_text = $form->promotion_text;
        $this->percent_to_calculate = $form->percent_to_calculate;
        $this->link = $form->link;
        $this->certificate_id = $form->certificate_id;
        $this->event_type = $form->event_type;
        $this->olimpic_id = $olimpic_id;
        $this->year = $form->year;
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
            'year' => 'Учебный год',
            'certificate_id' => 'Выдается сертификат участнику',
            'date_range' => 'Дата и время начала регистрации - дата и время завершения регистрации',
            'percent_to_calculate' => 'Процент участников в следующий тур',
        ];
    }

    public static function labels(): array
    {
        $olympic = new static();
        return $olympic->attributeLabels();
    }

    public function olympicRelation($id) {
      return  self::find()->where(['olimpic_id' => $id]);
    }

    public function olympicListRelation($id) {
        return  self::find()->where(['id' => $id]);
    }
    
    public function getEduLevelString () {
        return $this->edu_level_olymp ? OlympicHelper::levelOlimpName($this->edu_level_olymp) : 'Данные обновляются.';
    }

    public function getFacultyNameString () {
        return "Учредитель: ".($this->faculty_id ?DictFacultyHelper::facultyName($this->faculty_id) : "Данные обновляются");
    }

    public function getNumberOftoursNameString () {
        return "Количество туров: ".($this->number_of_tours ? OlympicHelper::numberOfToursName($this->number_of_tours) : 'Данные обновляются.');
    }

    public function getOnlyMpguStudentsString () {
        return $this->only_mpgu_students ? 'Только для студентов МПГУ' : '';
    }

    public function getFormOfPassageString () {
        return "Форма(ы) проведения: ". ($this->form_of_passage ? OlympicHelper::formOfPassageName($this->form_of_passage)  : 'Данные обновляются.');
    }

    public function getDateRegStartNameString () {
        return Html::tag('strong','Дата и время начала регистрации на сайте: '). ($this->date_time_start_reg ?
                    DateTimeCpuHelper::getDateChpu($this->date_time_start_reg)
                    . '  года в ' . DateTimeCpuHelper::getTimeChpu($this->date_time_start_reg)
                    : 'Данные обновляются.');
    }

    public function getDateRegEndNameString () {
        return Html::tag('strong','Дата и время завершения регистрации на сайте: '). ($this->date_time_finish_reg ?
            DateTimeCpuHelper::getDateChpu($this->date_time_finish_reg)
            . ' года в ' . DateTimeCpuHelper::getTimeChpu($this->date_time_finish_reg)
            : 'Данные обновляются.');
    }

    public function getTimeOfDistantsTourNameString () {
        return $this->time_of_distants_tour ?
            Html::tag('strong','Продолжительность выполнения заданий заочного тура: ') . $this->time_of_distants_tour . ' мин.'
            : '';
    }

    public function getTimeStartTourNameString () {
        return $this->date_time_start_tour ?
            Html::tag('strong','Дата и время проведения очного тура: ') .
            DateTimeCpuHelper::getDateChpu($this->date_time_start_tour) . ' года в ' . DateTimeCpuHelper::getTimeChpu($this->date_time_start_tour)
            : '';
    }

    public function getAddressNameString () {
        return $this->address ?
            Html::tag('strong','Адрес проведения очного тура: ') .$this->address
            : '';
    }

    public function getTimeOfTourNameString () {
        return $this->time_of_tour ?
            Html::tag('strong','Продолжительность очного тура: ') .$this->time_of_tour  . ' мин.'
            : '';
    }

    public function getContentString () {
        return $this->content ?
            Html::tag('div',$this->content, ['claass'=>'mt-30'])
            : '';
    }

    public function getIsOnRegisterOlympic() {
        $date =  date('Y-m-d H:i:s');
        return $this->date_time_finish_reg >= $date
            && $this->prefilling == false && $this->date_time_start_reg <= $date;
    }

    public function getTimeStartTourMatchDate() {
        return $this->date_time_start_tour <= date('Y-m-d H:i:s');
    }

    public function getIsDistanceTour() {
        return ($this->form_of_passage == OlympicHelper::ZAOCHNAYA_FORMA ||
            $this->form_of_passage == OlympicHelper::ZAOCHNO_OCHO_ZAOCHNAYA ||
            $this->form_of_passage == OlympicHelper::ZAOCHNO_ZAOCHNAYA ||
            $this->form_of_passage == OlympicHelper::OCHNO_ZAOCHNAYA_FORMA
        );
    }

    public function replaceLabelsFromTemplate () {
        return [
            DictChairmansHelper::chairmansNameOne($this->chairman_id), //Фамилия И.О. председателя
            $this->genitive_name,    //Название мероприятия в родительном падеже
            ClassAndOlympicHelper::olympicClassString($this->id), //классы/курсы участников
            DateTimeCpuHelper::getDateChpu($this->date_time_start_reg)
            . ' года в ' . DateTimeCpuHelper::getTimeChpu($this->date_time_start_reg),//дата и время начала регистрации
            DateTimeCpuHelper::getDateChpu($this->date_time_finish_reg)
            . ' года в ' . DateTimeCpuHelper::getTimeChpu($this->date_time_finish_reg),//дата и время завершения регистрации
            ($this->time_of_distants_tour_type == OlympicHelper::TIME_FIX ?
                'На выполнение заданий заочного (дистанционного) тура отводится ' . $this->time_of_distants_tour . ' минут'
                : 'Выполнить задания необходимо до завершения периода регистрации на настоящее Мероприятие'), //пункт3
            $this->date_time_start_tour ? DateTimeCpuHelper::getDateChpu($this->date_time_start_tour)
                . ' года в ' . DateTimeCpuHelper::getTimeChpu($this->date_time_start_tour) : '', //дата и время проведения очного тура
            $this->address, //адрес проведения очного тура
            $this->time_of_tour . ' минут', //продолжительность выполнения заданий очного тура в минутах
            OlimpicCgHelper::cgOlympicCompetitiveGroupList($this->id), //выбранные конкурсные группы
            OlympicHelper::showingWorkName($this->showing_works_and_appeal), // показ работ и апелляция
            ($this->showing_works_and_appeal == OlympicHelper::SHOW_WORK_YES ?
                'Апелляция проводится в соответствии с Положением об олимпиадах 
                и иных интеллектуальных и творческих конкурсах, не используемых 
                для получения особых прав и (или) преимуществ при поступлении 
                на обучение, проводимых МПГУ, размещенном сайте http://sdo.mpgu.org.' : ''), //текст аппеляции
            $this->requiment_to_work_of_distance_tour, //Требования к выполнению заданий заочного (дистанционного) тура
            $this->criteria_for_evaluating_dt, //Критерии оценивания заданий заочного тура
            $this->requiment_to_work,//Требования к выполнению заданий очного тура
            $this->criteria_for_evaluating,//Требования к выполнению заданий очного тура
        ];
    }

    public function replaceLabelsFromSending() {
        return [
            $this->genitive_name, // {название олимпиады в родительном падеже}
            DateTimeCpuHelper::getDateChpu($this->date_time_start_tour). ' года в ' . DateTimeCpuHelper::getTimeChpu($this->date_time_start_tour),
            $this->address, // {адрес проведения очного тура}
            DictChairmansHelper::chairmansNameOne($this->chairman_id), // {Ф.И.О. председателя олимпиады}
        ];
    }

    public function isFormOfPassageInternal () {
        return $this->form_of_passage == OlympicHelper::OCHNAYA_FORMA;
    }

    public function isFormOfPassageDistant () {
        return $this->form_of_passage == OlympicHelper::ZAOCHNAYA_FORMA;
    }

    public function isFormOfPassageDistantInternal () {
        return $this->form_of_passage == OlympicHelper::OCHNO_ZAOCHNAYA_FORMA;
    }

    public function isFormOfPassageDistantInternalDistant () {
        return $this->form_of_passage == OlympicHelper::ZAOCHNO_OCHO_ZAOCHNAYA;
    }

    public function isFormOfPassageDistantDistant () {
        return $this->form_of_passage == OlympicHelper::ZAOCHNO_ZAOCHNAYA;
    }

    public function isResultDistanceTour() {
       return $this->current_status &&
        ($this->isFormOfPassageDistant()
            || $this->isFormOfPassageDistantInternal());
    }

    public function isRegStatus() {
        return $this->current_status == OlympicHelper::REG_STATUS;
    }

    public function isResultEndTour() {
        return $this->current_status == OlympicHelper::OCH_FINISH;
    }

    public function isDistanceFinish() {
        return $this->current_status == OlympicHelper::ZAOCH_FINISH;
    }

    public function isTimeStartTour () {
        return $this->date_time_start_tour ? true : false;
    }

    public function  isPercentToCalculate() {
       return $this->percent_to_calculate;
    }

    public function isAppeal() {
       return $this->showing_works_and_appeal == OlympicHelper::SHOW_WORK_YES;
    }

    public function isStatusAppeal() {
        return $this->current_status == OlympicHelper::APPELLATION;
    }

    public function isStatusPreliminaryFinish() {
        return $this->current_status == OlympicHelper::PRELIMINARY_FINISH;
    }

    public function isCertificate() {
        return $this->certificate_id == OlympicHelper::CERTIFICATE_YES;
    }





}