<?php

namespace modules\entrant\forms;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\components\MaxDateValidate;
use modules\entrant\models\PassportData;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PassportDataForm extends Model
{
    public $nationality, $type, $series, $number, $date_of_birth, $user_id, $place_of_birth, $date_of_issue, $authority, $division_code;

    private $_passport;

    public function __construct($user_id, PassportData $passportData = null, $config = [])
    {
        if($passportData){
            $this->setAttributes($passportData->getAttributes(), false);
            $this->date_of_birth= $passportData->getValue("date_of_birth");
            $this->date_of_issue= $passportData->getValue("date_of_issue");
            $this->_passport = $passportData;
        } else {
            $this->nationality = \Yii::$app->user->identity->anketa()->citizenship_id;
            $this->user_id = $user_id;
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['nationality','type', 'series',
                'number', 'date_of_birth', 'place_of_birth','date_of_issue', 'authority'], 'required'],
            [['nationality','type', ], 'integer'],
            [['division_code'], 'string', 'max' => 7],
            [['series',],'string', 'max' => 10],
            [['number', 'place_of_birth', 'authority'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 255],
            [['division_code'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_PASSPORT_RUSSIA;},
                'whenClient' => 'function (attribute, value) { return $("#passportdataform-type").val() == 1}'],
            [['date_of_birth','date_of_issue',], 'safe'],
            [['date_of_issue',], 'validateDateOfBirth'],
            [['date_of_issue','date_of_birth'], MaxDateValidate::class],
            [['date_of_birth','date_of_issue'], 'date', 'format' => 'd.m.Y'],
            ['type', 'in', 'range' => DictIncomingDocumentTypeHelper::rangePassport($this->nationality)
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['type',], 'unique', 'targetClass' => PassportData::class,
            'targetAttribute' => ['type',  'series','number',]];
        if ($this->_passport) {
            return ArrayHelper::merge($arrayUnique, [ 'filter' => ['<>', 'id', $this->_passport->id]]);
        }
        return $arrayUnique;
    }

    public function validateDateOfBirth()
    {
        if (strtotime($this->date_of_birth) > strtotime($this->date_of_issue)) {
            $this->addError('date_of_issue', "Дата выдачи паспорта раньше, чем дата рождения " );
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new PassportData())->attributeLabels();
    }




}