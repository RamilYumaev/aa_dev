<?php

namespace modules\transfer\models;

use common\auth\models\User;
use modules\transfer\behaviors\FileBehavior;
use Yii;

/**
 * This is the model class for table "legal_entity_transfer".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $postcode
 * @property string $address_postcode
 * @property string $phone
 * @property string $bik
 * @property string $ogrn
 * @property string $inn
 * @property string $fio
 * @property string $position
 * @property string $footing
 * @property string|null $requisites
 * @property string $p_c
 * @property string $k_c
 * @property string|null $region Регион
 * @property string|null $district Район
 * @property string|null $city Город
 * @property string|null $village Посёлок
 * @property string|null $street Улица
 * @property string|null $house Дом
 * @property string|null $housing Корпус
 * @property string|null $building Строение
 * @property string|null $flat Квартира
 * @property string|null $surname Фамилия
 * @property string|null $first_name Имя
 * @property string|null $patronymic Отчество
 * @property string|null $bank Отделение банка
 *
 * @property User $user
 */
class LegalEntityTransfer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'legal_entity_transfer';
    }

    public function behaviors()
    {
        return [FileBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bik', 'bank', 'p_c','k_c','ogrn', 'inn', 'name','address_postcode', 'postcode', 'phone', 'fio', 'footing', 'position'], 'required'],
            [['surname', 'first_name', 'patronymic',],'string', 'max' => 255],
            [['surname', 'first_name', 'patronymic',], 'match', 'pattern' => '/^[а-яёА-ЯЁ\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел или тире'],
            [['surname', 'first_name'], 'required',],
            [['postcode', 'region', 'district', 'city', 'village', 'street', 'house',
                'housing', 'building', 'flat'],
                'string', 'max' => 255],
            [['bik', 'p_c','k_c', 'ogrn', 'inn', 'name','phone', 'address_postcode','requisites', 'fio', 'footing', 'position'],'string'],
        ];
    }

    public function getValue($property)
    {
        return $this->$property;
    }

    protected function getProperty($property)
    {
        return $this->getAttributeLabel($property) . ": " . $this->getValue($property);
    }

    public function getDataFull()
    {
        $string = "";
        foreach ($this->getAttributes(null, ['user_id', 'id']) as $key => $value) {
            if ($value) {
                $string .= $this->getProperty($key) . " ";
            }
        }
        return $string;
    }


    public function attributeLabels()
    {
        return [
            'bank' => 'Отделение банка',
            'bik' => "БИК",
            'p_c' => "Расчетный счет",
            'k_c' => "Корреспондетский счет",
            'ogrn' => 'ОГРНИП',
            'inn' => 'ИНН/КПП',
            'name' => 'Наименование организации',
            'address_postcode' => 'Почтовый адрес организации',
            'postcode' => 'Индекс',
            'region' => "Регион",
            'district' => "Район",
            'city' => "Город",
            'village' => "Посёлок",
            'street' => "Улица",
            'house' => "Дом",
            'housing' => "Корпус",
            'building' => "Строение",
            'flat' => "Квартира",
            'patronymic' => 'Отчество',
            'surname' => "Фамилия",
            'first_name' => 'Имя',
            'phone' => 'Контактный телефон организации',
            'requisites' => "Реквизиты документа, удостоверяющего полномочия представителя Заказчика",
            'fio' => "ФИО руководителя/представителя организации в родительном падеже",
            'footing' => "Наименование документа (Устава (Положения), доверенности и т.п.), удостоверяющего полномочия 
            представителя Заказчика в родительном падеже",
            'position' => "Должность в родительном падеже"
        ];
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
