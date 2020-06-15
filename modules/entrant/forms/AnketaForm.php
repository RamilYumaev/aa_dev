<?php

namespace modules\entrant\forms;


use modules\entrant\models\Anketa;
use yii\base\Model;

class AnketaForm extends Model
{
    public $user_id, $citizenship_id, $edu_finish_year, $current_edu_level, $category_id, $university_choice,
        $province_of_china,$personal_student_number, $is_foreigner_edu_organization;
    private $_anketaForm;

    public function __construct(Anketa $anketa = null, $config = [])
    {
        if ($anketa) {
            $this->citizenship_id = $anketa->citizenship_id;
            $this->edu_finish_year = $anketa->edu_finish_year;
            $this->current_edu_level = $anketa->current_edu_level;
            $this->category_id = $anketa->category_id;
            $this->user_id = $anketa->user_id;
            $this->university_choice = $anketa->university_choice;
            $this->province_of_china = $anketa->province_of_china;
            $this->personal_student_number = $anketa->personal_student_number;
            $this->is_foreigner_edu_organization = $anketa->is_foreigner_edu_organization;

        }else{
            $this->user_id = \Yii::$app->user->identity->getId();

        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['user_id', 'citizenship_id','current_edu_level','category_id', 'university_choice', 'is_foreigner_edu_organization'], 'integer'],
            [['user_id', 'citizenship_id', 'edu_finish_year','current_edu_level','category_id','university_choice'],
                'required'],
            [['personal_student_number', 'province_of_china'], 'string'],
            [['edu_finish_year'], 'date', 'format' => 'yyyy', 'min'=> 1950,'max'=> date("Y")],
            ['province_of_china', 'required', 'when' => function ($model) {
                return $model->citizenship_id == 13;
            }, 'whenClient' => 'function (attribute, value) { return $("#anketaform-citizenship_id").val() == 13}'],
            ['personal_student_number', 'required', 'when' => function ($model) {
                return $model->category_id == \modules\entrant\helpers\CategoryStruct::GOV_LINE_COMPETITION;
            }, 'whenClient' => 'function (attribute, value) { return $("#anketaform-category_id").val() == 5}'],

        ];
    }

    public function attributeLabels()
    {
        return (new Anketa())->attributeLabels();
    }
}