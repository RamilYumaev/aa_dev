<?php


namespace olympic\forms;


use common\helpers\EduYearHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictChairmans;
use olympic\forms\traits\OlympicTrait;
use olympic\helpers\ClassAndOlympicHelper;
use olympic\helpers\OlimpicCgHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use olympic\models\OlympicSpecialityOlimpicList;
use yii\base\Model;

class OlimpicListEditForm extends Model
{
    use OlympicTrait;

    public function __construct(OlimpicList $olympic, $config = [])
    {
        $this->competitiveGroupsList= OlimpicCgHelper::cgOlympicList($olympic->id);
        $this->classesList= ClassAndOlympicHelper::olympicClassList($olympic->id);
        $this->olympicSpecialityList = OlympicSpecialityOlimpicList::allOlympicSpecialityByOlympicList($olympic->id);
        $this->name = $olympic->name;
        $this->chairman_id = $olympic->chairman_id;
        $this->number_of_tours = $olympic->number_of_tours;
        $this->edu_level_olymp = $olympic->edu_level_olymp;
        $this->date_range = $olympic->date_time_start_reg ." - ". $olympic->date_time_finish_reg;
        $this->genitive_name = $olympic->genitive_name;
        $this->faculty_id = $olympic->faculty_id;
        $this->time_of_distants_tour_type = $olympic->time_of_distants_tour_type;
        $this->form_of_passage = $olympic->form_of_passage;
        $this->time_of_tour = $olympic->time_of_tour;
        $this->content = $olympic->content;
        $this->required_documents = $olympic->required_documents;
        $this->showing_works_and_appeal = $olympic->showing_works_and_appeal;
        $this->time_of_distants_tour = $olympic->time_of_distants_tour;
        $this->prefilling = $olympic->prefilling;
        $this->only_mpgu_students = $olympic->only_mpgu_students;
        $this->list_position = $olympic->list_position;
        $this->auto_sum = $olympic->auto_sum;
        $this->date_time_start_tour = $olympic->date_time_start_tour;
        $this->address = $olympic->address;
        $this->requiment_to_work_of_distance_tour = $olympic->requiment_to_work_of_distance_tour;
        $this->requiment_to_work = $olympic->requiment_to_work;
        $this->criteria_for_evaluating_dt = $olympic->criteria_for_evaluating_dt;
        $this->criteria_for_evaluating = $olympic->criteria_for_evaluating;
        $this->promotion_text = $olympic->promotion_text;
        $this->link = $olympic->link;
        $this->certificate_id = $olympic->certificate_id;
        $this->event_type = $olympic->event_type;
        $this->olimpic_id = $olympic->olimpic_id;
        $this->year = $olympic->year;
        $this->percent_to_calculate = $olympic->percent_to_calculate;
        $this->cg_no_visible = $olympic->cg_no_visible;
        $this->is_volunteering = $olympic->is_volunteering;
        $this->is_remote = $olympic->is_remote;
        $this->_olympic = $olympic;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'chairman_id', 'number_of_tours', 'edu_level_olymp', 'date_range', 'year', 'genitive_name', 'faculty_id'],
                'required', 'when' => function ($model) {
                return $model->prefilling == 0;
            }, 'whenClient' => 'function(attribute, value){
                    return $("#olimpiclisteditform-prefilling").val == 0}'],
            [[ 'classesList'], 'required', 'when' => function ($model) {
                return $model->edu_level_olymp == OlympicHelper::FOR_STUDENT
                    || $model->edu_level_olymp == OlympicHelper::FOR_PUPLE;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclisteditform-edu_level_olymp").val() == 1 
            || $("#olimpiclisteditform-edu_level_olymp").val() == 2}'],
            [['competitiveGroupsList'], 'required', 'when' => function ($model) {
                return ($model->edu_level_olymp == OlympicHelper::FOR_STUDENT && !$model->cg_no_visible)
                    || ($model->edu_level_olymp == OlympicHelper::FOR_PUPLE && !$model->cg_no_visible);
            }, 'whenClient' => 'function(attribute, value){
            return 
               ($("#olimpiclisteditform-edu_level_olymp").val() == 1 && !$("#olimpiclisteditform-cg_no_visible").prop("checked")) 
            || ($("#olimpiclisteditform-edu_level_olymp").val() == 2  && !$("#olimpiclisteditform-cg_no_visible").prop("checked"))}'],

            ['time_of_distants_tour_type', 'required', 'when' => function ($model) {
                return $model->form_of_passage == OlympicHelper::ZAOCHNAYA_FORMA;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclisteditform-form_of_passage").val() == 2; 
            }'],
            [['time_of_distants_tour_type','percent_to_calculate'], 'required', 'when' => function ($model) {
                return $model->number_of_tours == OlympicHelper::TWO_TOUR;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclisteditform-number_of_tours").val() == 2; 
            }'],
            ['form_of_passage', 'required', 'when' => function ($model) {
                return $model->number_of_tours == OlympicHelper::ONE_TOUR;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclisteditform-number_of_tours").val() == 1; 
            }'],
            ['time_of_distants_tour', 'required', 'when' => function ($model) {
                return $model->time_of_distants_tour_type == OlympicHelper::TIME_FIX;
            }, 'whenClient' => 'function(attribute, value){
                return $("#olimpiclisteditform-time_of_distants_tour_type").val() == 1;
            }'],
            [['olympicSpecialityList'], 'safe'],
            ['time_of_tour', 'required', 'when' => function ($model) {
                return $model->form_of_passage == OlympicHelper::OCHNAYA_FORMA;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclisteditform-form_of_passage").val() == 1; 
            }'],
            [['content', 'required_documents'], 'string'],
            [['name', 'year'], 'unique', 'targetClass' => OlimpicList::class, 'filter' => ['<>', 'id', $this->_olympic->id], 'message' => 'Такое название олимпиады и учебный год уже есть', 'targetAttribute' => ['name', 'year']],
            [['chairman_id', 'number_of_tours', 'cg_no_visible', 'is_remote', 'is_volunteering', 'form_of_passage', 'edu_level_olymp', 'showing_works_and_appeal',
                'time_of_distants_tour', 'time_of_tour', 'time_of_distants_tour_type', 'prefilling', 'faculty_id', 'olimpic_id',
                'only_mpgu_students', 'list_position', 'certificate_id', 'event_type', 'auto_sum'], 'integer'],
            [['date_range', 'date_time_start_tour'], 'safe'],
            [['competitiveGroupsList', 'classesList'], 'safe'],
            [['address', 'requiment_to_work_of_distance_tour', 'requiment_to_work', 'criteria_for_evaluating_dt', 'criteria_for_evaluating', 'genitive_name'], 'string'],
            [['name', 'year',], 'string', 'max' => 255],
            [['chairman_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictChairmans::class, 'targetAttribute' => ['chairman_id' => 'id']],
            [['promotion_text', 'link'], 'string', 'max' => 255],
            [['name'], 'required'],
            ['prefilling', 'in', 'range' => OlympicHelper::prefillingValid(), 'allowArray' => true],
            ['edu_level_olymp', 'in', 'range' => OlympicHelper::levelOlimpValid(), 'allowArray' => true],
            ['list_position', 'in', 'range' => OlympicHelper::listPositionValid(), 'allowArray' => true],
            ['time_of_distants_tour_type', 'in', 'range' => OlympicHelper::typeOfTimeDistanceTourValid(), 'allowArray' => true],
            ['number_of_tours', 'in', 'range' => OlympicHelper::numberOfToursValid(), 'allowArray' => true],
            ['form_of_passage', 'in', 'range' => OlympicHelper::formOfPassageValid(), 'allowArray' => true],
            ['showing_works_and_appeal', 'in', 'range' => OlympicHelper::showingWorkValid(), 'allowArray' => true],
            ['percent_to_calculate', 'number', 'when' => function ($model) {
                return $model->number_of_tours == OlympicHelper::TWO_TOUR;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclisteditform-number_of_tours").val() == 2; 
            }',  'min' => 40, 'max' => 60],
        ];
    }

}