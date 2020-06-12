<?php

namespace modules\entrant\forms;

use borales\extensions\phoneInput\PhoneInputValidator;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\PassportData;
use modules\entrant\models\PersonalEntity;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PersonalEntityForm extends Model
{
    public  $series, $number, $postcode, $address, $phone, $user_id, $date_of_issue, $authority, $fio;

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

    public function defaultRules()
    {
        return [
            [[ 'series',
                'number', 'date_of_issue','fio', 'authority', 'postcode', 'address', 'phone',], 'required'],
            [['series',],'string', 'max' => 4],
            [['series', 'number', 'date_of_issue','fio', 'authority', 'postcode', 'address', 'phone',],'string'],
            [['authority'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 15],
            [['date_of_issue',], 'safe'],
            [['date_of_issue'], 'date', 'format' => 'dd.mm.yyyy', 'max'=> date("d.m.Y")],
            [['phone'], 'string', 'max' => 25],
            ['phone', 'unique', 'targetClass' => PersonalEntity::class,
                'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
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

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new PersonalEntity())->attributeLabels();
    }




}