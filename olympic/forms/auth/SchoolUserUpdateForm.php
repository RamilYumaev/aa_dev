<?php


namespace olympic\forms\auth;

use common\auth\models\UserSchool;
use dictionary\helpers\DictClassHelper;
use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;

use dictionary\repositories\DictSchoolsRepository;
use yii\base\Model;

class SchoolUserUpdateForm extends  Model
{
    public $class_id;
    public $region_school;
    public $school_id;
    public $country_school;
    public $region_school_h;
    public $country_school_h;
    public $new_school;
    public $check_region_and_country_school;
    public $check_new_school;
    public $check_rename_school;
    public $school;


    public function __construct(UserSchool $userSchool, $config = [])
    {
        $this->check_region_and_country_school = true;
        $this->class_id = $userSchool->class_id;
        $this->school = $userSchool->school_id;
        $school = (new DictSchoolsRepository())->get($userSchool->school_id);
        $this->country_school_h = $school->country_id;
        $this->region_school_h = $school->region_id;

        parent::__construct($config);
    }
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['class_id'], 'required'],
            [['check_region_and_country_school', 'check_new_school', 'check_rename_school'],'boolean'],

            ['country_school', 'required', 'when' => function ($model) {
                return !$model->check_region_and_country_school;
            }, 'whenClient' => 'function (attribute, value) { return !$("#schooluserupdateform-check_region_and_country_school").prop("checked") }'],

            ['region_school', 'required', 'when' => function ($model) {
                return $model->country_school == 46 && !$model->check_region_and_country_school;
            },  'whenClient' => 'function (attribute, value) { return $("#schooluserupdateform-country_school").val() == 46  &&  
            !$("#schooluserupdateform-check_region_and_country_school").prop("checked") }'],

            ['new_school', 'required', 'when' => function ($model) {
                return $model->check_new_school || $model->check_rename_school;
            }, 'whenClient' => 'function (attribute, value) { return $("#schooluserupdateform-check_new_school").prop("checked")  ||   $("#schooluserupdateform-check_rename_school").prop("checked")  }'],

            ['school_id', 'required', 'when' => function ($model) {
                return !$model->check_new_school;
            }, 'whenClient' => 'function (attribute, value) { return !$("#schooluserupdateform-check_new_school").prop("checked") }'],

            [['school_id', 'class_id', 'country_school', 'school',  'region_school'], 'integer'],
            [['new_school'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'school_id' => 'Выберите образовательную организацию, в которой Вы обучаетесь (обучались)',
            'check_region_and_country_school' => 'Образовательная организация находится в том же регионе, что и место жительство',
            'country_school' => 'Страна, в которой находится Ваша образовательная организация',
            'region_school' => 'Регион, в котором находится Ваша образовательная организация',
            'class_id' => 'Выберите текущий класс/курс',
            'check_new_school' => 'В списке нет Вашей учебной организации?',
            'new_school' => 'Название учебной организации',
            'check_rename_school' => "Выбранная учебная организация называется по-другому?"
        ];
    }

    public function regionList(): array
    {
        return DictRegionHelper::regionList();
    }

    public function countryList(): array
    {
        return DictCountryHelper::countryList();
    }

    public function classFullNameList(): array
    {
        return DictClassHelper::classFullNameList();
    }
    
}