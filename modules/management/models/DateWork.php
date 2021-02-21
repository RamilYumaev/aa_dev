<?php


namespace modules\management\models;

use modules\management\forms\DateWorkForm;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $holiday
 * @property string $workday
 */
class DateWork extends ActiveRecord
{
    public static function tableName()
    {
        return "{{date_work}}";
    }

    public static function create(DateWorkForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(DateWorkForm $form)
    {
        $this->holiday = $form->holiday;
        $this->workday = $form->workday;
    }

    public function attributeLabels()
    {
        return [
            'holiday' => 'Выходной день',
            'workday' => "Рабочий день",
        ];
    }
}