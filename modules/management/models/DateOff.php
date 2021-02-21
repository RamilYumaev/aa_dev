<?php

namespace modules\management\models;

use modules\management\forms\DateOffForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%date_off}}".
 *
 * @property integer $id
 * @property string $note
 * @property boolean $isAllowed
 * @property integer $schedule_id
 * @property string $date
 **/

class DateOff extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%date_off}}';
    }

    public static function create(DateOffForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(DateOffForm $form)
    {
        $this->note = $form->note;
        $this->schedule_id = $form->schedule_id;
        $this->date = $form->date;
    }

    public function setIsAllowed($is)
    {
        $this->isAllowed = $is;
    }


    public function getSchedule() {
        return $this->hasOne(Schedule::class, ['id' => 'schedule_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'schedule_id' => 'Графикк работы сотрудника',
            'note' => 'Текст',
            'isAllowed' => "Разрешено?",
            'date' => "Дата отгула",
        ];
    }

}