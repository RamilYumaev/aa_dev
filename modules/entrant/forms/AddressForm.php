<?php

namespace modules\entrant\forms;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\models\Address;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AddressForm extends Model
{
    public $country_id, $type, $postcode, $region, $district, $city,
        $village, $street, $house, $housing, $building, $flat, $user_id;

    private $_address;

    public function __construct($user_id, Address $address = null, $config = [])
    {
        if($address){
            $this->setAttributes($address->getAttributes(), false);
            $this->_address = $address;
        }
        $this->user_id = $user_id;
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
        $arrayUnique = [['type'], 'unique', 'targetClass' => Address::class, 'targetAttribute' => ['type', 'user_id',]];
        if ($this->_address) {
               return ArrayHelper::merge($arrayUnique,['filter' => ['<>', 'id', $this->_address->id]]);
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
        return (new Address())->attributeLabels();
    }




}