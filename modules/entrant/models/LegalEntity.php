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
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%legal}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $requisites
 * @property string $fio
 * @property string $footing
 * @property string $position
 * @property string $bik
 * @property string $ogrn
 * @property string $p_c
 * @property string $k_c
 * @property string $inn
 * @property string $postcode,
 * @property string $address,
 * @property string $phone,
 *
**/

class LegalEntity extends ActiveRecord
{
    public function behaviors()
    {
        return [FileBehavior::class];
    }

    public static  function create(LegalEntityForm $form) {
        $legalEntity =  new static();
        $legalEntity->data($form);
        return $legalEntity;
    }

    public function data(LegalEntityForm $form)
    {
        $this->bik = $form->bik;
        $this->p_c = $form->p_c;
        $this->k_c = $form->k_c;
        $this->ogrn = $form->ogrn;
        $this->address = $form->address;
        $this->name = $form->name;
        $this->postcode = $form->postcode;
        $this->phone = $form->phone;
        $this->requisites = $form->requisites;
        $this->fio = $form->fio;
        $this->position = $form->position;
        $this->footing = $form->footing;
        $this->inn = $form->inn;

        $this->user_id = $form->user_id;
    }

    public function getValue($property){
          return $this->$property;
    }

    protected function getProperty($property){
        return $this->getAttributeLabel($property).": ".$this->getValue($property);
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

    public static function tableName()
    {
        return "{{%legal_entity}}";
    }

//    public function titleModeration(): string
//    {
//        return "Паспортные данные Физического лица";
//    }


//    public function moderationAttributes($value): array
//    {
//        return [
//            'bank' => $value, 'ogrn' => $value, 'inn' => $value, 'name' => $value,
//            'requisites'=> $value, 'fio'=> $value, 'footing'=> $value, 'position'=> $value,
//            'address' => $value,
//            'postcode' => $value,
//            'phone' => $value,
//            ];
//    }

    public function attributeLabels()
    {
        return [
            'bik' => "БИК",
            'p_c' => "Расчетный счет",
            'k_c' => "Корреспондетский счет",
            'ogrn' =>  'ОГРНИП',
            'inn'=>'ИНН/КПП',
            'name' => 'Наименование организации',
            'address' => 'Адрес места нахождения организации',
            'postcode' => 'Почтовый адрес организации',
            'phone' => 'Контактный телефон организации',
            'requisites'=> "Реквизиты документа, удостоверяющего полномочия представителя Заказчика",
            'fio'=> "ФИО руководителя/представителя организации в родительном падеже",
            'footing'=> "Наименование документа (Устава (Положения), доверенности и т.п.), удостоверяющего полномочия 
            представителя Заказчика в родительном падеже",
            'position'=> "Должность в родительном падеже"
        ];
    }
}