<?php

namespace modules\exam\forms;
use modules\exam\models\ExamStatement;
use yii\base\Model;

class ExamStatementProctorForm extends Model
{
    public $proctor_user_id, $time, $voz;

    public function __construct(ExamStatement $examStatement, $config = [])
    {
        $this->setAttributes($examStatement->getAttributes(), false);
        $this->voz = $examStatement->information->voz_id ? true : false;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['proctor_user_id', 'integer'],
            ['time', 'string', 'max'=>5],
            [['time'], 'required'],
            ['proctor_user_id', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'proctor_user_id'=> 'ФИО проктора', 'time' => 'Время начала',];
    }
}