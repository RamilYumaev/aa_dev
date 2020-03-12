<?php

namespace dod\forms;

use dod\models\DateDod;
use dod\models\Dod;
use yii\base\Model;

class DateDodCreateForm extends Model
{
    public $date_time, $dod_id, $broadcast_link, $text, $type;

    public function __construct(int $dod_id, $config = [])
    {
        $this->dod_id = $dod_id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['date_time', 'safe'],
            [['dod_id','type',], 'integer'],
            [['broadcast_link','text'], 'string'],
            ['date_time', 'unique', 'targetClass' => DateDod::class,
                'targetAttribute' => ['date_time', 'dod_id'], 'message' => 'Такая дата для данного ДОД уже введена'],
        ];
    }

    public function attributeLabels()
    {
        return DateDod::labels();
    }
}