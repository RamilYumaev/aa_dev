<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use DateTime;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\forms\PersonalEntityForm;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\repositories\PersonalEntityRepository;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%passport_data}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $series
 * @property string $number
 * @property string $date_of_issue
 * @property string $authority
 * @property string $postcode
 * @property string $region
 * @property string $district
 * @property string $city
 * @property string $village
 * @property string $street
 * @property string $house
 * @property string $patronymic
 * @property string $surname
 * @property string $name
 * @property string $housing
 * @property string $building
 * @property string $flat
 * @property string $division_code
 * @property string $address,
 * @property string $phone
 * @property string $email
 *
**/

class PersonalEntity extends ActiveRecord
{
    public function behaviors()
    {
        return [FileBehavior::class];
    }

    public static  function create(PersonalEntityForm $form) {
        $personalEntity =  new static();
        $personalEntity->data($form);
        return $personalEntity;
    }

    public function data(PersonalEntityForm $form)
    {
        $this->series = $form->series;
        $this->number = $form->number;
        $this->postcode = $form->postcode;
        $this->region = $form->region;
        $this->district = $form->district;
        $this->city = $form->city;
        $this->village = $form->village;
        $this->street = $form->street;
        $this->house = $form->house;
        $this->housing = $form->housing;
        $this->building  = $form->building;
        $this->flat = $form->flat;
        $this->division_code = $form->division_code;
        $this->phone = $form->phone;
        $this->date_of_issue =  DateFormatHelper::formatRecord($form->date_of_issue);
        $this->authority = mb_strtoupper($form->authority);
        $this->surname = $form->surname;
        $this->patronymic = $form->patronymic;
        $this->name = $form->name;
        $this->user_id = $form->user_id;
        $this->errors = $form->email;
    }

    public function getValue($property){
        if ($property == "date_of_issue") {
            return DateFormatHelper::formatView($this->$property);
            }
          return $this->$property;
    }

    protected function getProperty($property){
        return $this->getAttributeLabel($property).": ".$this->getValue($property);
    }
    protected function getPropertyAddress($property){
        return $this->attributeLabelsAddress()[$property]." ".$this->getValue($property);
    }


    public function getDataFull(){
        $string = "";
        foreach ($this->getAttributes(null,['user_id','id']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }

    public function getAddress(){
        $string = "";
        foreach ($this->getAttributes(null,[  'patronymic', 'user_id','id',
            'surname',
            'name',
            'series',
            'number',
            'division_code',
            'date_of_issue',
            'authority',
            'phone',]) as  $key => $value) {
            if($value) {
                $string .= $this->getPropertyAddress($key).", ";
            }
        }
        return $string;
    }

    public static function tableName()
    {
        return "{{%personal_entity}}";
    }

//    public function titleModeration(): string
//    {
//        return "Паспортные данные Физического лица";
//    }


//    public function moderationAttributes($value): array
//    {
//        return [
//            'fio'=> $value,
//            'series' => $value,
//            'number'=> $value,
//            'date_of_issue'=> DateFormatHelper::formatView($value),
//            'authority'=> $value,
//            'address' => $value,
//            'postcode' => $value,
//            'phone' => $value,
//            ];
//    }

    public function attributeLabels()
    {
        return [
            'patronymic' => 'Отчество',
            'surname' => "Фамилия",
            'name' => 'Имя',
            'series'=>'Серия паспорта',
            'number'=>'Номер паспорта',
            'division_code' => 'Код подразделения',
            'date_of_issue'=>'Дата выдачи паспорта',
            'authority'=>'Кем выдан паспорт',
            'phone' => 'Контактный телефон',
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

    public function getFio()
    {
        if (!empty($this->surname) && !empty($this->surname) && !empty($this->patronymic)) {
            return $this->surname . " " . $this->name . " " . $this->patronymic;
        } elseif (!empty($this->surname) && !empty($this->name)) {
            return $this->surname . " " . $this->name;
        }
        return null;
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function attributeLabelsAddress()
    {
        return [
            'postcode' => '',
            'region' => "",
            'district' => "",
            'city' => "",
            'village' => "",
            'street' => "",
            'house' => "",
            'housing' => "",
            'building' =>"",
            'flat' => "кв ",
        ];

    }
}