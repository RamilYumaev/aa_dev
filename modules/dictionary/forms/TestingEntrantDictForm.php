<?php

namespace modules\dictionary\forms;

use modules\dictionary\models\TestingEntrantDict;
use yii\base\Model;

class TestingEntrantDictForm extends Model
{
    public $message;

    public function __construct(TestingEntrantDict $testingEntrantDict, $config = [])
    {
        $this->message = $testingEntrantDict->error_note;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['message', 'string'],
            ['message', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'message'=> 'Сообщение об ошибке'];
    }
}