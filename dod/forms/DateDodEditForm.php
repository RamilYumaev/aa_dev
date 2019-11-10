<?php


namespace dod\forms;


use dod\helpers\DodHelper;
use dod\models\DateDod;
use yii\base\Model;

class DateDodEditForm extends Model
{
    public $date_time, $dod_id, $broadcast_link;
    public $_dateDod;

    public function __construct(DateDod $dateDod, $config = [])
    {
        $this->date_time = $dateDod->date_time;
        $this->dod_id = $dateDod->dod_id;
        $this->broadcast_link = $dateDod->broadcast_link;
        $this->_dateDod = $dateDod;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['date_time', 'safe'],
            ['dod_id', 'integer'],
            ['broadcast_link', 'string'],
            ['date_time', 'unique', 'targetClass' => DateDod::class, 'filter' => ['<>', 'id', $this->_dateDod->id],
                'targetAttribute' => ['date_time', 'dod_id'], 'message' => 'Такая дата для данного ДОД уже введена'],
        ];
    }

    public function attributeLabels()
    {
        return DateDod::labels();
    }

}