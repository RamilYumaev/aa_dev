<?php


namespace dod\forms;


use dod\helpers\DodHelper;
use dod\models\DateDod;
use yii\base\Model;

class DateDodForm extends Model
{
    public $date_time, $dod_id;

    public function __construct(DateDod $dateDod = null, $config = [])
    {
        if ($dateDod) {
            $this->date_time = $dateDod->date_time;
            $this->dod_id = $dateDod->dod_id;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['date_time', 'safe'],
            ['dod_id', 'integer'],
            ['date_time', 'unique', 'targetClass' => DateDod::class,
                'targetAttribute' => ['date_time', 'dod_id'], 'message' => 'Такая дата для данного ДОД уже введена'],
        ];
    }

    public function attributeLabels()
    {
        return DateDod::labels();
    }

    public function dodList(): array
    {
        return DodHelper::dodList();
    }


}