<?php

namespace modules\entrant\forms;

use modules\entrant\models\LegalEntity;
use yii\base\Model;

class LegalEntityForm extends Model
{
    public  $bik, $p_c, $k_c, $ogrn, $inn, $name, $postcode, $address_postcode,  $region, $district, $city,
        $village, $street, $house, $housing, $building, $flat, $phone, $user_id,
         $requisites, $fio, $footing, $position, $surname, $first_name, $patronymic, $bank;

    private $_legal;

    public function __construct($user_id, LegalEntity $legalEntity = null, $config = [])
    {
        if($legalEntity){
            $this->setAttributes($legalEntity->getAttributes(), false);
            $this->_legal = $legalEntity;
        } else {
            $this->user_id = $user_id;
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
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
    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return $this->defaultRules();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new LegalEntity())->attributeLabels();
    }




}