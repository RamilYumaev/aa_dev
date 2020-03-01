<?php

namespace modules\entrant\forms;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\dictionary\DictIncomingDocumentTypeHelper;
use modules\entrant\models\Address;
use modules\entrant\models\PassportData;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PassportDataForm extends Model
{
    public $nationality, $type, $series, $number, $date_of_birth, $place_of_birth, $date_of_issue, $authority, $division_code;

    private $_passport;

    public function __construct(PassportData $passportData = null, $config = [])
    {
        if($passportData){
            $this->setAttributes($passportData->getAttributes(), false);
            $this->_passport = $passportData;
        }
        $this->user_id = \Yii::$app->user->identity->getId();
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
            [['nationality','type' ], 'integer'],
            [['division_code'], 'string', 'max' => 7],
            [['series',],'string', 'max' => 4],
            [['number', 'place_of_birth', 'authority'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 15],
            [['date_of_birth','date_of_issue',], 'string',],
            ['type', 'in', 'range' => DictIncomingDocumentTypeHelper::rangeType(DictIncomingDocumentTypeHelper::TYPE_PASSPORT)
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        if ($this->_passport) {
            return [
                [['type'], 'unique', 'targetClass' => PassportData::class,
                    'filter' => ['<>', 'id', $this->_passport->id],
                    'targetAttribute' => ['type', 'user_id',]],
            ];
        }
        return [[['type',], 'unique', 'targetClass' => PassportData::class,
                'targetAttribute' => ['type', 'user_id',]]];
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), $this->uniqueRules());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new PassportData())->attributeLabels();
    }




}