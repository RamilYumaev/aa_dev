<?php

namespace modules\entrant\forms;

use common\helpers\EduYearHelper;
use modules\entrant\components\MaxDateValidate;
use modules\entrant\models\Agreement;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AgreementForm extends Model
{
    public $number, $date, $user_id, $year, $organization_id;
    public $name, $check_new, $check_rename;
    private $_agreement;
    

    public function __construct($user_id, Agreement $agreement = null, $config = [])
    {
        if($agreement) {
            $this->setAttributes($agreement->getAttributes(), false);
            $this->date = $agreement->getValue("date");
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
            [['organization_id'], 'integer'],
            ['organization_id', 'required', 'when' => function ($model) {
                return !$model->check_new;
            }, 'whenClient' => 'function (attribute, value) { return !$("#agreementform-check_new").prop("checked") }'],
            [['number',],'string', 'max' => 255],
            [['check_new', 'check_rename'],'boolean'],
            ['name', 'required', 'when' => function ($model) {
                return $model->check_new || $model->check_rename;
            }, 'whenClient' => 'function (attribute, value) { return $("#agreementform-check_new").prop("checked")  ||   
            $("#agreementform-check_rename").prop("checked")  }'],
            [['name'], 'string'],
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
        return array_merge((new Agreement())->attributeLabels(), $this->attributeLabelsStatic());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabelsStatic()
    {
        return [
            'check_new' => 'В списке нет Вашей организации?',
            'name' => 'Название организации',
            'check_rename' => "Выбранная организация называется по-другому?",
        ];
    }



}