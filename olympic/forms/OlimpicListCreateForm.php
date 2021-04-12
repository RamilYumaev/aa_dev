<?php


namespace olympic\forms;


use common\helpers\EduYearHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictChairmans;
use dictionary\helpers\DictChairmansHelper;
use olympic\forms\traits\OlympicTrait;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;

use yii\base\Model;

class OlimpicListCreateForm extends Model
{
    use OlympicTrait;

    public function __construct($olimpic_id, $config = [])
    {
        $this->olimpic_id = $olimpic_id;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chairman_id', 'number_of_tours', 'edu_level_olymp', 'date_range', 'year', 'genitive_name', 'faculty_id'],
                'required', 'when' => function ($model) {
                return $model->prefilling == 0;
            }, 'whenClient' => 'function(attribute, value){
                    return $("#olimpiclistcreateform-prefilling").val ==0}'],

            [[ 'classesList'], 'required', 'when' => function ($model) {
                return $model->edu_level_olymp == OlympicHelper::FOR_STUDENT
                    || $model->edu_level_olymp == OlympicHelper::FOR_PUPLE;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclistcreateform-edu_level_olymp").val() == 1 
            || $("#olimpiclistcreateform-edu_level_olymp").val() == 2}'],

            [['competitiveGroupsList'], 'required', 'when' => function ($model) {
                return ($model->edu_level_olymp == OlympicHelper::FOR_STUDENT && !$model->cg_no_visible)
                    || ($model->edu_level_olymp == OlympicHelper::FOR_PUPLE && !$model->cg_no_visible);
            }, 'whenClient' => 'function(attribute, value){
            return ($("#olimpiclistcreateform-edu_level_olymp").val() == 1 && !$("#olimpiclistcreateform-cg_no_visible").prop("checked")) 
            || ($("#olimpiclistcreateform-edu_level_olymp").val() == 2  && !$("#olimpiclistcreateform-cg_no_visible").prop("checked")) }'],
            [['time_of_distants_tour_type'], 'required', 'when' => function ($model) {
                return $model->form_of_passage == OlympicHelper::ZAOCHNAYA_FORMA;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclistcreateform-form_of_passage").val() == 2; 
            }'],
            [['time_of_distants_tour_type','percent_to_calculate'], 'required', 'when' => function ($model) {
                return $model->number_of_tours == OlympicHelper::TWO_TOUR;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclistcreateform-number_of_tours").val() == 2; 
            }'],
            ['form_of_passage', 'required', 'when' => function ($model) {
                return $model->number_of_tours == OlympicHelper::ONE_TOUR;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclistcreateform-number_of_tours").val() == 1; 
            }'],
            ['time_of_distants_tour', 'required', 'when' => function ($model) {
                return $model->time_of_distants_tour_type == OlympicHelper::TIME_FIX;
            }, 'whenClient' => 'function(attribute, value){
                return $("#olimpiclistcreateform-time_of_distants_tour_type").val() == 1;
            }'],
            ['time_of_tour', 'required', 'when' => function ($model) {
                return $model->form_of_passage == OlympicHelper::OCHNAYA_FORMA;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclistcreateform-form_of_passage").val() == 1; 
            }'],
            [['content', 'required_documents'], 'string'],
            [['name', 'year'], 'unique', 'targetClass' => OlimpicList::class, 'message' => 'Такое название олимпиады и учебный год уже есть',  'targetAttribute' => ['name', 'year']],
            [['chairman_id', 'number_of_tours', 'cg_no_visible', 'is_remote', 'is_volunteering', 'form_of_passage', 'edu_level_olymp', 'showing_works_and_appeal',
                'time_of_distants_tour', 'time_of_tour', 'time_of_distants_tour_type', 'prefilling', 'faculty_id',
                'only_mpgu_students', 'list_position', 'certificate_id', 'event_type', 'auto_sum', 'olimpic_id',
                ], 'integer'],
            [['date_range', 'date_time_start_tour'], 'safe'],
            [['competitiveGroupsList', 'classesList'], 'safe'],
            [['address', 'requiment_to_work_of_distance_tour', 'requiment_to_work', 'criteria_for_evaluating_dt', 'criteria_for_evaluating', 'genitive_name'], 'string'],
            [['name','year'], 'string', 'max' => 255],
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
            return $("#olimpiclistcreateform-number_of_tours").val() == 2; 
            }',  'min' => 40, 'max' => 60],
        ];
    }
}