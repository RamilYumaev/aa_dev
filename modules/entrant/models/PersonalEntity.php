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

/**
 * This is the model class for table "{{%passport_data}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $fio
 * @property string $series
 * @property string $number
 * @property string $date_of_issue
 * @property string $authority
 * @property string $postcode,
 * @property string $address,
 * @property string $phone,
 *
**/

class PersonalEntity extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => ['fio', 'series', 'number', 'date_of_issue', 'authority',
                  'postcode', 'address', 'phone',]
        ]];
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
        $this->address = $form->address;
        $this->fio = $form->fio;
        $this->postcode = $form->postcode;
        $this->phone = $form->phone;
        $this->date_of_issue =  DateFormatHelper::formatRecord($form->date_of_issue);
        $this->authority = mb_strtoupper($form->authority);
        $this->user_id = $form->user_id;
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

    public function getPassportFull(){
        $string = "";
        foreach ($this->getAttributes(null,['user_id','id']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }

    public static function tableName()
    {
        return "{{%personal_entity}}";
    }

    public function titleModeration(): string
    {
        return "Паспортные данные Физического лица";
    }


    public function moderationAttributes($value): array
    {
        return [
            'fio'=> $value,
            'series' => $value,
            'number'=> $value,
            'date_of_issue'=> DateFormatHelper::formatView($value),
            'authority'=> $value,
            'address' => $value,
            'postcode' => $value,
            'phone' => $value,
            ];
    }

    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'series'=>'Серия',
            'number'=>'Номер',
            'date_of_issue'=>'Дата выдачи',
            'authority'=>'Кем выдан',
            'address' => 'Адрес регистрации',
            'postcode' => 'Почтовый адрес',
            'phone' => 'Контактный телефон',
        ];
    }
}