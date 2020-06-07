<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use DateTime;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\forms\LegalEntityForm;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "{{%legal}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $bank
 * @property string $ogrn
 * @property string $inn
 * @property string $postcode,
 * @property string $address,
 * @property string $phone,
 *
**/

class LegalEntity extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => ['bank', 'ogrn', 'inn', 'name',
                  'postcode', 'address', 'phone',]
        ]];
    }

    public static  function create(LegalEntityForm $form) {
        $legalEntity =  new static();
        $legalEntity->data($form);
        return $legalEntity;
    }

    public function data(LegalEntityForm $form)
    {
        $this->bank = $form->bank;
        $this->ogrn = $form->ogrn;
        $this->address = $form->address;
        $this->name = $form->name;
        $this->postcode = $form->postcode;
        $this->phone = $form->phone;
        $this->inn = $form->inn;
        $this->user_id = $form->user_id;
    }

    public function getValue($property){
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
        return "{{%legal_entity}}";
    }

    public function titleModeration(): string
    {
        return "Паспортные данные Физического лица";
    }


    public function moderationAttributes($value): array
    {
        return [
            'bank' => $value, 'ogrn' => $value, 'inn' => $value, 'name' => $value,
            'address' => $value,
            'postcode' => $value,
            'phone' => $value,
            ];
    }

    public function attributeLabels()
    {
        return [
            'bank' => "Банковские реквизиты",
            'ogrn' =>  'ОГРН',
            'inn'=>'ИНН/КПП',
            'name' => 'Наименование',
            'address' => 'Адрес места нахождения',
            'postcode' => 'Почтовый адресс',
            'phone' => 'Контактный телефон',
        ];
    }
}