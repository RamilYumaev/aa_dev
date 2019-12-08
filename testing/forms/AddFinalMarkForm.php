<?php

namespace testing\forms;
use olympic\models\PersonalPresenceAttempt;
use yii\base\Model;

class AddFinalMarkForm extends Model
{
    public $mark;
    public $id;
    public $attempt;

    public function __construct(PersonalPresenceAttempt $attempt, $config = [])
    {
        $this->attempt = $attempt;
        $this->mark = $attempt->mark;
        $this->id = $attempt->id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['mark', 'required'],
            ['mark', 'number', 'min' => 0, 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mark' => 'Оценка',
        ];
    }
}