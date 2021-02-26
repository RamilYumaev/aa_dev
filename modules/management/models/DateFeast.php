<?php


namespace modules\management\models;

use modules\management\forms\DateWorkForm;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $date
 */
class DateFeast extends ActiveRecord
{
    public static function tableName()
    {
        return "{{date_feast}}";
    }

    public static function create($date)
    {
        $model = new static();
        $model->data($date);
        return $model;
    }

    public function data($date)
    {
        $this->date = $date->date;
    }

    public function attributeLabels()
    {
        return [
            'date' => 'Выходной день',
        ];
    }
}