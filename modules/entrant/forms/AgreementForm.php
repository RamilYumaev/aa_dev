<?php

namespace modules\entrant\forms;

use common\helpers\EduYearHelper;
use modules\entrant\components\MaxDateValidate;
use modules\entrant\models\Agreement;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AgreementForm extends Model
{
    public $number, $date, $user_id, $year;
    private $_agreement;
    

    public function __construct($user_id, Agreement $agreement = null, $config = [])
    {
        if($agreement) {
            $this->setAttributes($agreement->getAttributes(), false);
            $this->date =  $agreement->date ? $agreement->getValue("date") : null;
            $this->_agreement = $agreement;
        }
        $this->user_id =$user_id;
        $this->year= EduYearHelper::eduYear();
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['date'], 'required'],
            [['date'], MaxDateValidate::class],
            [['number',],'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['user_id',], 'unique', 'targetClass' => agreement::class,
            'targetAttribute' => ['year', 'user_id']];
        if ($this->_agreement) {
            return ArrayHelper::merge($arrayUnique, ['filter' => ['<>', 'id', $this->_agreement->id]]);
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
        return (new Agreement())->attributeLabels();
    }
}