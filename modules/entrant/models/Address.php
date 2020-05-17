<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\forms\AddressForm;
use modules\entrant\helpers\AddressHelper;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $country_id
 * @property integer $type
 * @property string $postcode
 * @property string $region
 * @property string $district
 * @property string $city
 * @property string $village
 * @property string $street
 * @property string $house
 * @property string $housing
 * @property string $building
 * @property string $flat
**/

class Address extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['country_id', 'type', 'postcode', 'region', 'district',
                'city', 'village', 'street', 'house', 'housing', 'building', 'flat']
        ]];
    }

    public static  function create(AddressForm $form) {
        $address =  new static();
        $address->data($form);
        return $address;
    }

    public function data(AddressForm $form) {
        $this->country_id = $form->country_id;
        $this->type = $form->type;
        $this->postcode = $form->postcode;
        $this->region = $form->region;
        $this->district = $form->district;
        $this->village = $form->village;
        $this->street = $form->street;
        $this->house = $form->house;
        $this->housing = $form->housing;
        $this->building  = $form->building;
        $this->flat = $form->flat;
        $this->user_id = $form->user_id;
    }

    protected function getProperty($property){
        return $this->getAttributeLabel($property).": ".$this->$property;
    }

    public function getAdders(){
        $string = "";
        foreach ($this->getAttributes(null,['user_id', 'country_id', 'type', 'id']) as  $key => $value) {
            if($value) {
                $string .= $value.", ";
            }
        }
        return rtrim ($string, ", ");
    }

    public function getAddersFull(){
        $string = "";
        foreach ($this->getAttributes(null,['user_id', 'country_id', 'type', 'id']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }

    public function getTypeName() {
        return AddressHelper::typeName($this->type);
    }

    public function getCountryName()
    {
        return  DictCountryHelper::countryName($this->country_id);
    }

    public static function tableName()
    {
        return "{{%address}}";
    }

    public function titleModeration(): string
    {
        return "Адрес проживания";
    }

    public function moderationAttributes($value): array
    {
        return [
            'country_id' => DictCountryHelper::countryName($value),
            'type' => AddressHelper::typeName($value),
            'postcode' => $value,
            'region' => $value,
            'district' => $value,
            'city' => $value,
            'village' => $value,
            'street' => $value,
            'house' => $value,
            'housing' => $value,
            'building' => $value,
            'flat' => $value
        ];
    }

    public function dataArray()
    {
        return [
            'full' => $this->countryName.", ". $this->getAdders()
            ];
    }

    public function attributeLabels()
    {
        return [
            'country_id' =>"Страна",
            'type' => "Тип адреса",
            'postcode' => 'Индекс',
            'region' => "Регион",
            'district' => "Район",
            'city' => "Город",
            'village' => "Посёлок",
            'street' => "Улица",
            'house' => "Дом",
            'housing' => "Корпус",
            'building' =>"Строение",
            'flat' => "Квартира",
        ];
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

}