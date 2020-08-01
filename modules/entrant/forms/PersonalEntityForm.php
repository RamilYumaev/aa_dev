<?php

namespace modules\entrant\forms;

use borales\extensions\phoneInput\PhoneInputValidator;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\components\MaxDateValidate;
use modules\entrant\models\PassportData;
use modules\entrant\models\PersonalEntity;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PersonalEntityForm extends Model
{
    public  $series, $number, $postcode, $region, $district, $city,
        $division_code,
        $village, $street, $house, $housing, $building, $flat, $phone, $user_id,
        $surname, $name, $patronymic,
        $date_of_issue, $authority;

    private $_personal;

    public function __construct($user_id, PersonalEntity $personalEntity = null, $config = [])
    {
        if($personalEntity){
            $this->setAttributes($personalEntity->getAttributes(), false);
            $this->date_of_issue= $personalEntity->getValue("date_of_issue");
            $this->_personal= $personalEntity;
        } else {
            $this->user_id = $user_id;
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [[ 'series',
                'number', 'date_of_issue', 'authority', 'postcode', 'phone',], 'required'],
            [['series',],'string', 'max' => 4],
            [['series', 'number', 'date_of_issue', 'authority', 'postcode',  'phone',
                ],'string'],
            [['surname', 'name', 'patronymic',],'string', 'max' => 255],
            [['surname', 'name', 'patronymic',], 'match', 'pattern' => '/^[а-яёА-ЯЁ\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел или тире'],
            [['surname', 'name'], 'required',],
                [['division_code'], 'string', 'max' => 7],
            [['postcode', 'region', 'district', 'city', 'village', 'street', 'house',
                'housing', 'building', 'flat'],
                'string', 'max' => 255],
            [['authority'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 15],
            [['date_of_issue',], 'safe'],
            [['date_of_issue'], 'date', 'format' => 'dd.mm.yyyy'],
            [['date_of_issue'], MaxDateValidate::class],
            [['phone'], 'string', 'max' => 25],
           // $this->uniqueRules(),
           // $this->uniquePhone(),
            [['phone'], PhoneInputValidator::class],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['series'], 'unique', 'targetClass' => PersonalEntity::class,
            'targetAttribute' => [ 'series','number',]];
        if ($this->_personal) {
            return ArrayHelper::merge($arrayUnique, [ 'filter' => ['<>', 'id', $this->_personal->id]]);
        }
        return $arrayUnique;
    }

    /**
     * {@inheritdoc}
     */
    public function uniquePhone()
    {
        $phoneUnique = [['phone'], 'unique', 'targetClass' => PersonalEntity::class,
            'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'];
        if ($this->_personal) {
            return ArrayHelper::merge($phoneUnique, [ 'filter' => ['<>', 'id', $this->_personal->id]]);
        }
        return $phoneUnique;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new PersonalEntity())->attributeLabels();
    }




}