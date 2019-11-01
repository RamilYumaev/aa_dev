<?php


namespace olympic\forms;


use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictChairmans;
use dictionary\helpers\DictChairmansHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use olympic\models\Olympic;
use yii\base\Model;

class OlimpicListCreateForm extends Model
{
    public $name,
        $chairman_id,
        $number_of_tours,
        $edu_level_olymp,
        $date_time_start_reg,
        $date_time_finish_reg,
        $genitive_name,
        $faculty_id,
        $competitiveGroupsList,
        $classesList,
        $time_of_distants_tour_type,
        $form_of_passage,
        $time_of_tour,
        $content,
        $required_documents,
        $showing_works_and_appeal,
        $time_of_distants_tour,
        $prefilling,
        $only_mpgu_students,
        $list_position,
        $current_status,
        $auto_sum,
        $date_time_start_tour,
        $address,
        $requiment_to_work_of_distance_tour,
        $requiment_to_work,
        $criteria_for_evaluating_dt,
        $criteria_for_evaluating,
        $promotion_text,
        $link,
        $certificate_id,
        $olimpic_id,
        $year,
        $event_type;

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
            [['name', 'chairman_id', 'number_of_tours', 'edu_level_olymp', 'date_time_start_reg',
                'date_time_finish_reg', 'year', 'genitive_name', 'faculty_id'],
                'required', 'when' => function ($model) {
                return $model->prefilling == 0;
            }, 'whenClient' => 'function(attribute, value){
                    return $("#olimpiclistcreateform-prefilling").val ==0}'],

            [['competitiveGroupsList', 'classesList'], 'required', 'when' => function ($model) {
                return $model->edu_level_olymp == OlympicHelper::FOR_STUDENT
                    || $model->edu_level_olymp == OlympicHelper::FOR_PUPLE;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclistcreateform-edu_level_olymp").val() == 1 
            || $("#olimpiclistcreateform-edu_level_olymp").val() == 2}'],
            ['time_of_distants_tour_type', 'required', 'when' => function ($model) {
                return $model->form_of_passage == OlympicHelper::ZAOCHNAYA_FORMA;
            }, 'whenClient' => 'function(attribute, value){
            return $("#olimpiclistcreateform-form_of_passage").val() == 2; 
            }'],
            ['time_of_distants_tour_type', 'required', 'when' => function ($model) {
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
            return $("#form_of_passage").val() == 1; 
            }'],
            [['content', 'required_documents'], 'string'],
            [['name', 'year'], 'unique', 'targetClass' => OlimpicList::class, 'message' => 'Такое название олимпиады и год уже есть',  'targetAttribute' => ['name', 'year']],
            [['chairman_id', 'number_of_tours', 'form_of_passage', 'edu_level_olymp', 'showing_works_and_appeal',
                'time_of_distants_tour', 'time_of_tour', 'time_of_distants_tour_type', 'prefilling', 'faculty_id',
                'only_mpgu_students', 'list_position', 'certificate_id', 'event_type', 'current_status', 'auto_sum', 'olimpic_id',
                'year',], 'integer'],
            [['date_time_start_reg', 'date_time_finish_reg', 'date_time_start_tour'], 'safe'],
            [['competitiveGroupsList', 'classesList'], 'safe'],
            [['address', 'requiment_to_work_of_distance_tour', 'requiment_to_work', 'criteria_for_evaluating_dt', 'criteria_for_evaluating', 'genitive_name'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['chairman_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictChairmans::class, 'targetAttribute' => ['chairman_id' => 'id']],
            [['promotion_text', 'link'], 'string', 'max' => 255],
            [['promotion_text'], 'required'],
            ['prefilling', 'in', 'range' => OlympicHelper::prefillingValid(), 'allowArray' => true],
            ['edu_level_olymp', 'in', 'range' => OlympicHelper::levelOlimpValid(), 'allowArray' => true],
            ['list_position', 'in', 'range' => OlympicHelper::listPositionValid(), 'allowArray' => true],
            ['time_of_distants_tour_type', 'in', 'range' => OlympicHelper::typeOfTimeDistanceTourValid(), 'allowArray' => true],
            ['number_of_tours', 'in', 'range' => OlympicHelper::numberOfToursValid(), 'allowArray' => true],
            ['form_of_passage', 'in', 'range' => OlympicHelper::formOfPassageValid(), 'allowArray' => true],
            ['showing_works_and_appeal', 'in', 'range' => OlympicHelper::showingWorkValid(), 'allowArray' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return OlimpicList::labels();
    }

    public function facultyList(): array
    {
        return DictFacultyHelper::facultyList();
    }

    public function numberOfTours()
    {
        return OlympicHelper::numberOfTours();
    }

    public function listPosition()
    {
        return OlympicHelper::listPosition();
    }

    public function formOfPassage()
    {
        return OlympicHelper::formOfPassage();
    }

    public function levelOlimp()
    {
        return OlympicHelper::levelOlimp();
    }

    public function showingWork()
    {
        return OlympicHelper::showingWork();
    }

    public function prefilling()
    {
        return OlympicHelper::prefilling();
    }

    public function chairmansFullNameList()
    {
        return DictChairmansHelper::chairmansFullNameList();
    }

    public  function typeOfTimeDistanceTour() {

        return OlympicHelper::typeOfTimeDistanceTour();
    }

    public function years(): array
    {
        $year = date("Y");
        $year = $year - 1;
        $result = [];
        for ($i = 1; $i <= 3; $i++) {
            $result[$year+$i] = $year+$i;

        }
        return $result;
    }
}