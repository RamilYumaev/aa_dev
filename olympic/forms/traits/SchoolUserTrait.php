<?php

namespace olympic\forms\traits;

use common\auth\models\UserSchool;
use dictionary\helpers\DictClassHelper;
use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use dictionary\repositories\DictSchoolsRepository;
use olympic\helpers\auth\ProfileHelper;
use yii\helpers\ArrayHelper;

trait SchoolUserTrait
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

     public $role;

     public $selectorUpdate = "#schooluserupdateform";
     public $selectorCreate = "#schooluserform";

    public function defaultUpdateData($user) {
        $this->defaultDataCheck();
         if ($this->role == ProfileHelper::ROLE_STUDENT) {
             $this->defaultClassIdUpdateData($user);
         }
         $this->school = $user->school_id;
         $school = (new DictSchoolsRepository())->get($user->school_id);
         $this->country_school_h = $school->country_id;
         $this->region_school_h = $school->region_id;
     }

    public function defaultClassIdUpdateData($userSchool) {
        if ($userSchool instanceof UserSchool) {
            return $this->class_id = $userSchool->class_id;
        }
    }

    public function defaultDataCheck()
    {
      return  $this->check_region_and_country_school = true;
    }

    public function attributeLabels(): array
    {
        return [
            'school_id' => $this->getStringSchoolId(),
            'check_region_and_country_school' => 'Образовательная организация находится в том же регионе, что и место жительство',
            'country_school' => 'Страна, в которой находится Ваша образовательная организация',
            'region_school' => 'Регион, в котором находится Ваша образовательная организация',
            'class_id' => 'Выберите текущий класс/курс',
            'check_new_school' => 'В списке нет Вашей учебной организации?',
            'new_school' => 'Название учебной организации',
            'check_rename_school' => "Выбранная учебная организация называется по-другому?"
        ];
    }

    public function getStringSchoolId(): string
    {
        if ($this->role == ProfileHelper::ROLE_TEACHER) {
           return 'Выберите образовательную организацию, в которой Вы работаете (работали)';
        }

        return 'Выберите образовательную организацию, в которой Вы обучаетесь (обучались)';
    }

    /**
     * @inheritdoc
     */
    public function rulesValidateAndSelector($selector): array
    {
        return [
            [['check_region_and_country_school', 'check_new_school', 'check_rename_school'],'boolean'],
            [['school_id','country_school', 'school',  'region_school'], 'integer'],
            [['new_school'], 'string'],
            [['new_school'], 'match', 'pattern' => '/^[а-яёА-ЯЁ0-9,.№\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы, цифры, пробел, тире, запятую, точку, знак номера'],

            ['country_school', 'required', 'when' => function ($model) {
                return !$model->check_region_and_country_school;
            }, 'whenClient' => 'function (attribute, value) { return !$("'.$selector.'-check_region_and_country_school").prop("checked") }'],

            ['region_school', 'required', 'when' => function ($model) {
                return $model->country_school == 46 && !$model->check_region_and_country_school;
            },  'whenClient' => 'function (attribute, value) { return $("'.$selector.'-country_school").val() == 46  &&  
            !$("'.$selector.'-check_region_and_country_school").prop("checked") }'],

            ['new_school', 'required', 'when' => function ($model) {
                return $model->check_new_school || $model->check_rename_school;
            }, 'whenClient' => 'function (attribute, value) { return $("'.$selector.'-check_new_school").prop("checked")  ||   
            $("'.$selector.'-check_rename_school").prop("checked")  }'],

            ['school_id', 'required', 'when' => function ($model) {
                return !$model->check_new_school;
            }, 'whenClient' => 'function (attribute, value) { return !$("'.$selector.'-check_new_school").prop("checked") }'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rulesValidateClassId(): array
    {
        return [
            [['class_id'], 'required'],
            [['class_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rulesValidateRole($role, $selector): array
    {
        if ($role == ProfileHelper::ROLE_TEACHER || is_null($role)) {
            return  $this->rulesValidateAndSelector($selector);
        }
        return  ArrayHelper::merge($this->rulesValidateAndSelector($selector), $this->rulesValidateClassId());
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