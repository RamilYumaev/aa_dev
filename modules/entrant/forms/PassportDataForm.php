<?php

namespace modules\entrant\forms;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\components\MaxDateValidate;
use modules\entrant\models\PassportData;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PassportDataForm extends Model
{
    public $nationality, $type, $series, $number, $date_of_birth, $user_id, $place_of_birth, $date_of_issue,
        $authority, $division_code;

    private $_passport;

    private $requiredAttributes;

    public function __construct($user_id, PassportData $passportData = null, $requiredAttributes = [], $config = [])
    {
        if ($passportData) {
            $this->setAttributes($passportData->getAttributes(), false);
            $this->date_of_birth = $passportData->date_of_birth ? $passportData->getValue("date_of_birth") : null;
            $this->date_of_issue = $passportData->getValue("date_of_issue");
            $this->_passport = $passportData;
        } else {
            $this->user_id = $user_id;
        }
        $this->requiredAttributes = $requiredAttributes;
        if (!$requiredAttributes) {
            $this->nationality = \Yii::$app->user->identity->anketa()->citizenship_id;
        }


        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [$this->requiredAttributes(), 'required'],
            [['nationality', 'type',], 'integer'],
            [['division_code'], 'string', 'max' => 7],
            [['series',], 'string', 'max' => 10],
            [['number', 'place_of_birth', 'authority'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 255],
            [['division_code'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_PASSPORT_RUSSIA;
            },
                'whenClient' => 'function (attribute, value) { return $("#passportdataform-type").val() == 1}'],
            [['date_of_birth', 'date_of_issue',], 'safe'],
            [['date_of_issue',], 'validateDateOfBirth'],
            [['authority','place_of_birth'], 'match', 'pattern' => '/^[а-яёА-ЯЁ0-9,.\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы, цифры, пробел, тире, запятую, точку'],
            [['date_of_issue', 'date_of_birth'], MaxDateValidate::class],
            [['date_of_birth', 'date_of_issue'], 'date', 'format' => 'd.m.Y'],
            !$this->requiredAttributes ?
                ['type', 'in', 'range' => DictIncomingDocumentTypeHelper::rangePassport($this->nationality)] :
                ['type', 'in', 'range' => [DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT,
                    DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT]]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        if($this->requiredAttributes)
        {
            $arrayUnique = [['number'], 'unique', 'targetClass' => PassportData::class,
                'targetAttribute' => ['type', 'number',]];
            if ($this->_passport) {
                return ArrayHelper::merge($arrayUnique, ['filter' => ['<>', 'id', $this->_passport->id]]);
            }
            return $arrayUnique;

        }else{
            $arrayUnique = [['type','number'], 'unique', 'targetClass' => PassportData::class,
                'targetAttribute' => ['type', 'series', 'number',]];
            if ($this->_passport) {
                return ArrayHelper::merge($arrayUnique, ['filter' => ['<>', 'id', $this->_passport->id]]);
            }
            return $arrayUnique;
        }

    }

    public function validateDateOfBirth()
    {
        if (strtotime($this->date_of_birth) > strtotime($this->date_of_issue)) {
            $this->addError('date_of_issue', "Дата выдачи паспорта раньше, чем дата рождения ");
            return false;
        }
        return true;
    }

    public function requiredAttributes()
    {
        if ($this->requiredAttributes) {
            return $this->requiredAttributes;
        }
        return ['nationality', 'type', 'series',
            'number', 'date_of_birth', 'place_of_birth', 'date_of_issue', 'authority'];
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