<?php

namespace modules\entrant\models;
use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\dictionary\helpers\DictOrganizationsHelper;
use modules\entrant\forms\AgreementForm;
use modules\entrant\helpers\DateFormatHelper;

/**
 * This is the model class for table "{{%agreement}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $organization_id
 * @property string  $date
 * @property string  $number
 * @property string  $year
 **/

class Agreement extends YiiActiveRecordAndModeration
{

    public static function tableName()
    {
        return '{{%agreement}}';
    }

//    public function behaviors()
//    {
////        return [
////            'moderation' => [
////            'class'=> ModerationBehavior::class,
////            'attributes'=>['organization_id', 'number', 'date', 'year']
////        ]];
//    }

    public static  function create(AgreementForm $form, $organization_id) {
        $address =  new static();
        $address->data($form, $organization_id);
        return $address;
    }

    public function data(AgreementForm $form, $organization_id)
    {
        $this->date = DateFormatHelper::formatRecord($form->date);
        $this->year = $form->year;
        $this->number = $form->number;
        $this->user_id = $form->user_id;
        $this->organization_id = $organization_id;
    }
    public function attributeLabels()
    {
        return [
             'organization_id' => "Организация",
             'date' => 'Дата договора',
             'number'=> 'Номер договора',
             'year' =>   'Год'
        ];
    }

    public function titleModeration(): string
    {
          return  'Договоры(целевое обучение)';
    }

    public function getValue($property){
        if ($property == "date") {
            return DateFormatHelper::formatView($this->$property);
        }
        return $this->$property;
    }


    public function moderationAttributes($value): array
    {
        return [
            'organization_id' => DictOrganizationsHelper::organizationName($value),
            'date' => DateFormatHelper::formatView($value),
            'number'=> $value,
            'year' =>  $value,
        ];
    }
}