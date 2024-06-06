<?php

namespace modules\exam\forms;

use yii\base\Model;

class ExamDateReserveForm extends Model
{
    public $date;
    public $exam_id;
    public $time;

    const PUBLIC_ENTRANT = 1;
    const PUBLIC_TRANSFER = 2;

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['date', 'safe', 'on' => [static::PUBLIC_ENTRANT, static::PUBLIC_TRANSFER]],
            ['date', 'required', 'on' => [static::PUBLIC_ENTRANT, static::PUBLIC_TRANSFER]],
            ['exam_id', 'required', 'on' => [ static::PUBLIC_TRANSFER]],
            ['time', 'required', 'on' => [static::PUBLIC_TRANSFER]],
            ['date', 'date', 'format' => 'php:Y-m-d', 'on' => [static::PUBLIC_ENTRANT, static::PUBLIC_TRANSFER]],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'date' => 'Дата',  'exam_id' => 'Дисциплина', 'time' => "Условное время"];
    }
}