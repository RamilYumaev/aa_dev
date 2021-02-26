<?php

namespace modules\management\forms;


use modules\management\models\DateWork;
use yii\base\Model;

class DateWorkForm extends Model
{
    public $holiday, $workday;
    private $_DateWork;

    public function __construct(DateWork $DateWork = null, $config = [])
    {
        if ($DateWork) {
            $this->setAttributes($DateWork->getAttributes(), false);
            $this->_DateWork = $DateWork;
        }

        parent::__construct($config);
    }
    

    public function defaultRules()
    {
        return [
            [['holiday', 'workday'], 'required'],
            [['holiday', 'workday'], 'safe'],
            [['holiday', 'workday'], 'date', 'format' => 'yyyy-M-d'],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['holiday'], 'unique', 'targetClass' => DateWork::class, 'targetAttribute' => ['holiday', 'workday']];
        if ($this->_DateWork) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_DateWork->id]]);
        }

        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DateWork())->attributeLabels();
    }
}