<?php

namespace modules\entrant\forms;
use modules\entrant\helpers\AddressHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\Address;
use modules\entrant\models\PassportData;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PassportDataForm extends Model
{
    public $nationality, $type, $series, $number, $main_status, $date_of_birth, $user_id, $place_of_birth, $date_of_issue, $authority, $division_code;

    private $_passport;

    public function __construct(PassportData $passportData = null, $config = [])
    {
        if($passportData){
            $this->setAttributes($passportData->getAttributes(), false);
            $this->date_of_birth= $passportData->getValue("date_of_birth");
            $this->date_of_issue= $passportData->getValue("date_of_issue");
            $this->_passport = $passportData;
        } else {
            $this->nationality = \Yii::$app->user->identity->anketa()->citizenship_id;
            $this->user_id = \Yii::$app->user->identity->getId();
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
            [['nationality','type', 'main_status' ], 'integer'],
            [['division_code'], 'string', 'max' => 7],
            [['series',],'string', 'max' => 4],
            [['number', 'place_of_birth', 'authority'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 15],
            [['division_code'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_PASSPORT_RUSSIA;},
                'whenClient' => 'function (attribute, value) { return $("#passportdataform-type").val() == 1}'],
            [['date_of_birth','date_of_issue',], 'safe'],
            [['date_of_birth','date_of_issue'], 'date', 'format' => 'dd.mm.yyyy'],
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
            'targetAttribute' => ['type', 'user_id',]];
        if ($this->_passport) {
            return ArrayHelper::merge($arrayUnique, [ 'filter' => ['<>', 'id', $this->_passport->id]]);
        }
        return $arrayUnique;
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