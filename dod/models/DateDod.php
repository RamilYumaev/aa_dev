<?php


namespace dod\models;


use yii\db\ActiveRecord;

class DateDod extends ActiveRecord
{
    public static function tableName()
    {
        return 'date_dod';
    }

    public static function create($date_time, $dod_id)
    {
        $dateDod = new static();
        $dateDod->date_time = $date_time;
        $dateDod->dod_id = $dod_id;
        return $dateDod;
    }

    public function edit($date_time, $dod_id)
    {
        $this->date_time = $date_time;
        $this->dod_id = $dod_id;
    }

    public function attributeLabels()
    {
        return [
            'date_time' => 'Дата и время',
        ];
    }

    public static function labels(): array
    {
        $dateDod = new static();
        return $dateDod->attributeLabels();
    }



}