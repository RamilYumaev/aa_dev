<?php

namespace modules\management\forms;


use modules\management\models\DateFeast;
use yii\base\Model;

class DateFeastForm extends Model
{
    public $date;
    private $_DateFeast;

    public function __construct(DateFeast $DateFeast = null, $config = [])
    {
        if ($DateFeast) {
            $this->setAttributes($DateFeast->getAttributes(), false);
            $this->_DateFeast = $DateFeast;
        }

        parent::__construct($config);
    }
    

    public function defaultRules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['date'], 'date', 'format' => 'yyyy-M-d'],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['date'], 'unique', 'targetClass' => DateFeast::class];
        if ($this->_DateFeast) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_DateFeast->id]]);
        }

        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DateFeast())->attributeLabels();
    }
}