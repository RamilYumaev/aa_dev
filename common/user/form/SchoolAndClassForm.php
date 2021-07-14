<?php

namespace common\user\form;

use common\auth\models\SettingEmail;
use common\auth\traits\SettingEmailTrait;
use dictionary\helpers\DictCountryHelper;
use dictionary\models\DictSchools;
use modules\dictionary\models\DictExaminer;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class SchoolAndClassForm extends Model
{
    public $name,
        $region_id,
        $school_id,
        $class_id,
        $country_id;


    const UPDATE_CREATE = 'scvvv';
    const SELECT_REPLACE = 'deeee';

    public function __construct(DictSchools $dictSchools = null, $config = [])
    {
        if($dictSchools){
            $this->school_id = $dictSchools->id;
            $this->setAttributes($dictSchools->getAttributes(), false);
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [[ 'country_id', 'class_id', 'name'], 'required', 'on' => self::UPDATE_CREATE],
            [['school_id','class_id'], 'required', 'on' => self::SELECT_REPLACE],
            [['region_id'], 'required', 'when' => function ($model) {
                return $model->country_id == DictCountryHelper::RUSSIA;
            },'on' => self::UPDATE_CREATE,  'enableClientValidation' => false],
            [['region_id', 'country_id', 'class_id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return (new DictSchools())->attributeLabels()+['class_id' => 'Выберите текущий класс/курс'];
    }
}