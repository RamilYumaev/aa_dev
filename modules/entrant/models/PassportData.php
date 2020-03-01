<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\forms\AddressForm;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\dictionary\DictIncomingDocumentTypeHelper;

/**
 * This is the model class for table "{{%passport_data}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $nationality
 * @property integer $type
 * @property string $series
 * @property string $number
 * @property string $date_of_birth
 * @property string $place_of_birth
 * @property string $date_of_issue
 * @property string $authority
 * @property string $division_code
 *
**/

class PassportData extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>[ 'nationality','type', 'series', 'number', 'date_of_birth', 'place_of_birth','date_of_issue', 'authority',
                'division_code']
        ]];
    }

    public static  function create(PassportDataForm $form) {
        $address =  new static();
        $address->data($form);
        return $address;
    }

    public function data(PassportDataForm $form) {
        $this->nationality = $form->nationality;
        $this->type = $form->type;
        $this->series = $form->series;
        $this->number = $form->number;
        $this->date_of_birth = $form->date_of_birth;
        $this->place_of_birth = $form->place_of_birth;
        $this->date_of_issue = $form->date_of_issue;
        $this->authority = $form->authority;
        $this->division_code = $form->division_code;
        $this->user_id = $form->user_id;
    }

    protected function getProperty($property){
        return $this->getAttributeLabel($property).": ".$this->$property;
    }

    public function getPassportFull(){
        $string = "";
        foreach ($this->getAttributes(null,['user_id', 'type', 'id']) as  $key => $value) {
            if($value) {
                $string .= $this->getProperty($key)." ";
            }
        }
        return $string;
    }

    public static function tableName()
    {
        return "{{%passport_data}}";
    }

    public function titleModeration(): string
    {
        return "Паспортные данные";
    }

    public function moderationAttributes($value): array
    {
        return [
            'nationality' => DictCountryHelper::countryName($value),
            'type' => DictIncomingDocumentTypeHelper::typeName(DictIncomingDocumentTypeHelper::TYPE_PASSPORT, $value),
            'series' => $value,
            'place_of_birth' => $value,
            'number'=> $value,
            'date_of_birth'=> $value,
            'date_of_issue'=> $value,
            'authority'=> $value,
            'division_code'=> $value,
            ];
    }

    public function attributeLabels()
    {
        return [
            'nationality' => 'Гражданство',
            'type'=>'Тип документа',
            'series'=>'Серия',
            'number'=>'Номер',
            'date_of_birth'=>'Дата рождения',
            'place_of_birth'=>'Место рождения',
            'date_of_issue'=>'Дата выдачи',
            'authority'=>'Кем выдан',
            'division_code'=>'Код подразделения'
        ];
    }

}