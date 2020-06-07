<?php

namespace modules\entrant\forms;

use modules\entrant\models\LegalEntity;
use yii\base\Model;

class LegalEntityForm extends Model
{
    public  $bank, $ogrn, $inn, $name, $postcode, $address, $phone, $user_id;

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
            [['bank', 'ogrn', 'inn', 'name', 'postcode', 'address', 'phone',], 'required'],
            [['bank', 'ogrn', 'inn', 'name', 'postcode', 'address', 'phone',],'string'],
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