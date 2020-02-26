<?php

namespace modules\entrant\forms;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\models\Address;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AddressForm extends Model
{
    public $country_id, $type, $postcode, $region, $district, $city, $village, $street, $house, $housing, $building, $flat, $user_id;

    private $_address;

    public function __construct(Address $address = null, $config = [])
    {
        if($address){
            $this->country_id = $address->country_id;
            $this->type = $address->type;
            $this->postcode = $address->postcode;
            $this->region = $address->region;
            $this->district = $address->district;
            $this->village = $address->village;
            $this->street = $address->street;
            $this->house = $address->house;
            $this->housing = $address->housing;
            $this->building  = $address->building;
            $this->flat = $address->flat;
            $this->_address = $address;
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
            [['country_id','type'], 'required'],
            [['country_id','type'], 'integer'],
            [['postcode', 'region', 'district', 'city', 'village', 'street', 'house', 'housing', 'building', 'flat'],
                'string', 'max' => 255],
            ['type', 'in', 'range' => AddressHelper::rangeAddress()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        if ($this->_address) {
            return [
                [['type', 'user_id',], 'unique', 'targetClass' => Address::class,
                    'filter' => ['<>', 'id', $this->_address->id],
                    'targetAttribute' => ['type', 'user_id',]],
            ];
        }
        return [[['type', 'user_id',], 'unique', 'targetClass' => Address::class,
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
        return (new Address())->attributeLabels();
    }




}