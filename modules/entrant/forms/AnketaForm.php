<?php

namespace modules\entrant\forms;


use modules\entrant\models\Anketa;
use yii\base\Model;

class AnketaForm extends Model
{
    public $user_id, $citizenship_id, $is_agree, $current_edu_level, $category_id, $is_dlnr_ua,
        $province_of_china, $personal_student_number, $is_foreigner_edu_organization;
    public $speciality_spo;

    public function __construct(Anketa $anketa = null, $config = [])
    {
        $this->category_id = 1;
        $this->is_dlnr_ua = 0;
        if ($anketa) {
            $this->citizenship_id = $anketa->citizenship_id;
            $this->is_agree = $anketa->is_agree;
            $this->current_edu_level = $anketa->current_edu_level;
            $this->user_id = $anketa->user_id;
            $this->province_of_china = $anketa->province_of_china;
            $this->personal_student_number = $anketa->personal_student_number;
            $this->is_foreigner_edu_organization = $anketa->is_foreigner_edu_organization;
            $this->speciality_spo = $anketa->speciality_spo;
        } else {
            $this->user_id = \Yii::$app->user->identity->getId();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['user_id', 'citizenship_id','current_edu_level','category_id', 'is_foreigner_edu_organization', 'is_dlnr_ua'], 'integer'],
            [['user_id', 'citizenship_id','current_edu_level','category_id'],
                'required'],
            ['is_agree', 'required', 'requiredValue' => true, 'message' => 'Подтвердите, пожалуйста, что Вы ознакомлены с инструкцией по подаче документов'],
            [['personal_student_number', 'province_of_china'], 'string'],
            [['speciality_spo'], 'safe'],
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