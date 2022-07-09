<?php

namespace modules\exam\forms;
use yii\base\Model;

class ExamStatementForm extends Model
{
    public $date;
    public $discipline;
    public $isProctor;


    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['date', 'required'],
            ['discipline', 'integer'],
            ['date', 'date', 'format'=> 'yyyy-mm-dd'],
            ['isProctor', 'boolean']
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [
           'date'=> 'Дата сформмрования заявки',
           'discipline' => 'Дисциплина',
           'isProctor' => 'Прокторы?'
           ];
    }
}