<?php

namespace modules\management\forms;


use modules\management\models\DateOff;
use yii\base\Model;

class DateOffForm extends Model
{
    public $schedule_id, $note, $date;
    private $_dateOff;
    public $description;

    public function __construct(DateOff $dateOff = null, $config = [])
    {
        if ($dateOff) {
            $this->setAttributes($dateOff->getAttributes(), false);
            $this->_dateOff = $dateOff;
        }

        parent::__construct($config);
    }
    

    public function defaultRules()
    {
        return [
            [['schedule_id', 'date', 'note'], 'required'],
            [['date'], 'safe'],
            [['schedule_id'], 'integer'],
            [['date'], 'date', 'format' => 'yyyy-M-d'],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['schedule_id'], 'unique', 'targetClass' => DateOff::class, 'targetAttribute' => ['schedule_id', 'date']];
        if ($this->_dateOff) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_dateOff->id]]);
        }

        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DateOff())->attributeLabels();
    }
}