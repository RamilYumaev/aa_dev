<?php

namespace modules\exam\forms;

use modules\exam\models\ExamStatement;
use yii\base\Model;

class ExamDateReserveForm extends Model
{
    public $date;

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['date', 'safe'],
            ['date', 'required'],
            ['date', 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'date' => 'Дата'];
    }
}